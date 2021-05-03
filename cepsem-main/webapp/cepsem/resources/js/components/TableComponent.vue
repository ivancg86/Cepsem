<template>
  <div class="table-responsive py-4">
    <table class="table table-hover">
      <thead>
        <tr class="table-danger">
          <th scope="col" v-for="(camp, index) in camps" :key="index">
            {{ camp }}
          </th>
        </tr>
      </thead>

      <div v-show="loading" class="table-loading">
        <p>{{ error }}</p>
        <div class="progress-line"></div>
      </div>

      <tbody>
        <tr class="table-info py-5" v-for="(row, index) in rows" :key="index">
          <td v-for="(field, index) in row" :key="index">{{ field }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    taula: {
      type: String,
      required: true,
    },

    camps: {
      type: Array,
      required: true,
    },

    afegir: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      rows: [],
      loading: true,
      error: "Carregant les dades...",
    };
  },
  created() {
    let me = this;

    axios
      .get("/" + this.taula)
      .then((response) => {
        me.rows = response.data;
        this.loading = false;
      })
      .catch((error) => {
        console.log(error);
        this.error = error;
      });
  },
  mounted() {
    console.log("Table component mounted.");
  },
  computed: {

  },
};
</script>
