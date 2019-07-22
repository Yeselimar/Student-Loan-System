<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher\Dumper;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * PhpMatcherDumper creates a PHP class able to match URLs for a given set of routes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 * @author Arnaud Le Blanc <arnaud.lb@gmail.com>
 */
class PhpMatcherDumper extends MatcherDumper
{
    private $expressionLanguage;

    /**
     * @var ExpressionFunctionProviderInterface[]
     */
    private $expressionLanguageProviders = [];

    /**
     * Dumps a set of routes to a PHP class.
     *
     * Available options:
     *
     *  * class:      The class name
     *  * base_class: The base class name
     *
     * @param array $options An array of options
     *
     * @return string A PHP class representing the matcher class
     */
    public function dump(array $options = [])
    {
        $options = array_replace([
            'class' => 'ProjectUrlMatcher',
            'base_class' => 'Symfony\\Component\\Routing\\Matcher\\UrlMatcher',
        ], $options);

        // trailing slash support is only enabled if we know how to redirect the user
        $interfaces = class_implements($options['base_class']);
        $supportsRedirections = isset($interfaces['Symfony\\Component\\Routing\\Matcher\\RedirectableUrlMatcherInterface']);

        return <<<EOF
<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class {$options['class']} extends {$options['base_class']}
{
    public function __construct(RequestContext \$context)
    {
        \$this->context = \$context;
    }

{$this->generateMatchMethod($supportsRedirections)}
}

EOF;
    }

    public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
    {
        $this->expressionLanguageProviders[] = $provider;
    }

    /**
     * Generates the code for the match method implementing UrlMatcherInterface.
     *
     * @param bool $supportsRedirections Whether redirections are supported by the base class
     *
     * @return string Match method as PHP code
     */
    private function generateMatchMethod($supportsRedirections)
    {
        $code = rtrim($this->compileRoutes($this->getRoutes(), $supportsRedirections), "\n");

        return <<<EOF
    public function match(\$rawPathinfo)
    {
        \$allow = [];
        \$pathinfo = rawurldecode(\$rawPathinfo);
        \$trimmedPathinfo = rtrim(\$pathinfo, '/');
        \$context = \$this->context;
        \$request = \$this->request ?: \$this->createRequest(\$pathinfo);
        \$requestMethod = \$canonicalMethod = \$context->getMethod();

        if ('HEAD' === \$requestMethod) {
            \$canonicalMethod = 'GET';
        }

$code

        throw 0 < count(\$allow) ? new MethodNotAllowedException(array_unique(\$allow)) : new ResourceNotFoundException();
    }
EOF;
    }

    /**
     * Generates PHP code to match a RouteCollection with all its routes.
     *
     * @param RouteCollection $routes               A RouteCollection instance
     * @param bool            $supportsRedirections Whether redirections are supported by the base class
     *
     * @return string PHP code
     */
    private function compileRoutes(RouteCollection $routes, $supportsRedirections)
    {
        $fetchedHost = false;
        $groups = $this->groupRoutesByHostRegex($routes);
        $code = '';

        foreach ($groups as $collection) {
            if (null !== $regex = $collection->getAttribute('host_regex')) {
                if (!$fetchedHost) {
                    $code .= "        \$host = \$context->getHost();\n\n";
                    $fetchedHost = true;
                }

                $code .= sprintf("        if (preg_match(%s, \$host, \$hostMatches)) {\n", var_export($regex, true));
            }

            $tree = $this->buildStaticPrefixCollection($collection);
            $groupCode = $this->compileStaticPrefixRoutes($tree, $supportsRedirections);

            if (null !== $regex) {
                // apply extra indention at each line (except empty ones)
                $groupCode = preg_replace('/^.{2,}$/m', '    $0', $groupCode);
                $code .= $groupCode;
                $code .= "        }\n\n";
            } else {
                $code .= $groupCode;
            }
        }

        // used to display the Welcome Page in apps that don't define a homepage
        $code .= "        if ('/' === \$pathinfo && !\$allow) {\n";
        $code .= "            throw new Symfony\Component\Routing\Exception\NoConfigurationException();\n";
        $code .= "        }\n";

        return $code;
    }

    private function buildStaticPrefixCollection(DumperCollection $collection)
    {
        $prefixCollection = new StaticPrefixCollection();

        foreach ($collection as $dumperRoute) {
            $prefix = $dumperRoute->getRoute()->compile()->getStaticPrefix();
            $prefixCollection->addRoute($prefix, $dumperRoute);
        }

        $prefixCollection->optimizeGroups();

        return $prefixCollection;
    }

    /**
     * Generates PHP code to match a tree of routes.
     *
     * @param StaticPrefixCollection $collection           A StaticPrefixCollection instance
     * @param bool                   $supportsRedirections Whether redirections are supported by the base class
     * @param string                 $ifOrElseIf           either "if" or "elseif" to influence chaining
     *
     * @return string PHP code
     */
    private function compileStaticPrefixRoutes(StaticPrefixCollection $collection, $supportsRedirections, $ifOrElseIf = 'if')
    {
        $code = '';
        $prefix = $collection->getPrefix();

        if (!empty($prefix) && '/' !== $prefix) {
            $code .= sprintf("    %s (0 === strpos(\$pathinfo, %s)) {\n", $ifOrElseIf, var_export($prefix, true));
        }

        $ifOrElseIf = 'if';

        foreach ($collection->getItems() as $route) {
            if ($route instanceof StaticPrefixCollection) {
                $code .= $this->compileStaticPrefixRoutes($route, $supportsRedirections, $ifOrElseIf);
                $ifOrElseIf = 'elseif';
            } else {
                $code .= $this->compileRoute($route[1]->getRoute(), $route[1]->getName(), $supportsRedirections, $prefix)."\n";
                $ifOrElseIf = 'if';
            }
        }

        if (!empty($prefix) && '/' !== $prefix) {
            $code .= "    }\n\n";
            // apply extra indention at each line (except empty ones)
            $code = preg_replace('/^.{2,}$/m', '    $0', $code);
        }

        return $code;
    }

    /**
     * Compiles a single Route to PHP code used to match it against the path info.
     *
     * @param Route       $route                A Route instance
     * @param string      $name                 The name of the Route
     * @param bool        $supportsRedirections Whether redirections are supported by the base class
     * @param string|null $parentPrefix         The prefix of the parent collection used to optimize the code
     *
     * @return string PHP code
     *
     * @throws \LogicException
     */
    private function compileRoute(Route $route, $name, $supportsRedirections, $p