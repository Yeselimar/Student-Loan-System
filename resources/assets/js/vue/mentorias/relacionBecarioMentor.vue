<script>

import vSelect from 'vue-select'
Vue.component('v-select',vSelect);
Vue.use(BootstrapVue);

import relacionBecarioMentor from "../../components/relacionBecarioMentorComponent.vue";
const app = new Vue({
  el: "#relacionBecarioMentorID",
  components: {
    relacionBecarioMentor
  }
});
</script>