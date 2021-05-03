<template>
  <a :href="'/cepsem/webapp/cepsem/public/cecos/' + page">
    <div class="cepsem-card cepsem-card--scale" :class="[{'cepsem-card--secondary':secondary}, cardSize]">
      <h2>{{ name }}</h2>
      <div class="cepsem-gradient cepsem-gradient--blue" style="width: 100%;height: 100%;position: absolute;top: 0;left: 0;border-radius: inherit;"></div>
      </div>
  </a>
</template>

<script>
export default {
  props: {
    page: {
      type: String,
      required: true,
    },

    name: {
      type: String,
      required: true,
    },

    size: {
      type: String,
      required: true,
    },

    secondary: {
        type: Boolean,
        required: true,
    }
  },
  data() {
    return {};
  },
  created() {},
  mounted() {
    console.log("Menu card " + this.name + " component mounted.");
  },
  computed: {
      cardSize() {
          return "cepsem-card--" + this.size;
      },
  },
};
</script>

