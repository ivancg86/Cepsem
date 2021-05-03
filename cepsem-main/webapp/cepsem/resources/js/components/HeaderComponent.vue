<template>
  <div style="position: sticky; top: 0;z-index: 1000;">
    <div class="header">
        <!-- <a href="#" class="header-logo"></a> -->
        <div href="#" class="header-logo"></div>

      <div class="header-main">
        <nav class="header-nav">
          <a href="/cepsem/webapp/cepsem/public/">Inici</a>
          <a href="/cepsem/webapp/cepsem/public/cecos/">CECOS</a>
          <a href="/cepsem/webapp/cepsem/public/cecos/recursMobil">Recursos Mòbils</a>
          <a href="/cepsem/webapp/cepsem/public/formacio">Formació</a>
        </nav>
      </div>

      <div class="header-trail">
        <div v-show="helpbox" class="header-icon header-icon--helpbox"></div>
        <div v-show="formacio" class="header-icon header-icon--formacio"></div>
        <div v-show="username">
          <span>Hola, {{ username }}</span>
          <a
            href="/cepsem/webapp/cepsem/public/logout"
            class="header-logout"
          ></a>
        </div>
        <div class="header-icon  header-icon--menu"></div>
      </div>
    </div>

    <div class="formacio-llistat">
      <a href="" class="video-item">
        <div class="video-thumbail">v</div>
        <div class="video-info">
          <h3>video title</h3>
          <p>video desc</p>
        </div>
      </a>

      <a href="" class="video-item">
        <div class="video-thumbail"></div>
        <div class="video-info">
          <h3>video title</h3>
          <p>video desc</p>
        </div>
      </a>

      <a href="" class="video-item">
        <div class="video-thumbail"></div>
        <div class="video-info">
          <h3>video title</h3>
          <p>video desc</p>
        </div>
      </a>

      <a href="" class="button button-icon button--blue mt-4">VEURE MÉS</a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    formacio: {
      type: Boolean,
      required: true,
    },

    helpbox: {
      type: Boolean,
      required: true,
    },

    username: {
      type: String,
      required: false,
    },
  },
  data() {
    return {};
  },
  created() {},
  mounted() {
    console.log("Header component mounted.");
  },
  computed: {},
};
</script>
