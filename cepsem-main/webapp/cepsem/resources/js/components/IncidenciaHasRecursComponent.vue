<template>
  <div>
    <h1 class="page-title">RECURS MOBIL</h1>

    <div class="d-flex justify-content-end mb-4">
      <a
        href="/cepsem/webapp/cepsem/public/cecos/incidencia/-1"
        class="button button-icon button--pink"
        id="show-btn"
      >
        VULL LA MEVA INCIDENCIA
      </a>
    </div>

    <div v-if="loading" class="table-loading">
      <p>{{ loadingStatus }}</p>
      <div class="progress-line"></div>
    </div>

    <div v-else class="animate__animated animate__fadeIn">

      <b-table
        id="incidencies-table"
        :fields="fields"
        :items="incidencies"
        :per-page="perPage"
        :current-page="currentPage"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left
        ref="selectableTable"
        selectable
        large
        hover
      >
        <template #cell(Seleccionat)="{ rowSelected }">
          <template v-if="rowSelected">
            <span aria-hidden="true">&check;</span>
            <span class="sr-only">Selected</span>
          </template>
          <template v-else>
            <span aria-hidden="true">&nbsp;</span>
            <span class="sr-only">Not selected</span>
          </template>
        </template>

        <template #cell(Veure)="data">
          <a :href="'/cepsem/webapp/cepsem/public/cecos/incidencia/' + data.item.id ">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#11AEBF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 6.5c3.79 0 7.17 2.13 8.82 5.5-1.65 3.37-5.02 5.5-8.82 5.5S4.83 15.37 3.18 12C4.83 8.63 8.21 6.5 12 6.5m0-2C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 5c1.38 0 2.5 1.12 2.5 2.5s-1.12 2.5-2.5 2.5-2.5-1.12-2.5-2.5 1.12-2.5 2.5-2.5m0-2c-2.48 0-4.5 2.02-4.5 4.5s2.02 4.5 4.5 4.5 4.5-2.02 4.5-4.5-2.02-4.5-4.5-4.5z"/></svg>
          </a>
        </template>
      </b-table>

      <b-pagination
        class="mt-5"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="incidencies-table"
      ></b-pagination>
    </div>

  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      sortBy: "id",
      sortDesc: false,
      perPage: 10,
      currentPage: 1,
      incidencies: [],
      editClick: false,

      fields: [
        { key: "data", label: "Data", sortable: true },
        { key: "hora", label: "Hora", sortable: true },
        { key: "telefon_alertant", label: "Tlf. Alertant", sortable: true },
        { key: "adreca", label: "Adreça", sortable: true },
        { key: "adreca_complement", label: "Adreça Comp.", sortable: true },
        { key: "descripcio", label: "Descripció", sortable: true },
        { key: "tipus_incidencia.tipus", label: "Tipus", sortable: true },
        { key: "municipi.comarca.provincia.nom", label: "Provincia", sortable: true },
        { key: "municipi.comarca.nom", label: "Comarca", sortable: true },
        { key: "municipi.nom", label: "Municipi", sortable: true },
        { key: "recursos.codi", label: "Codi", sortable: true },
        "Veure",
      ],
      loading: true,
      loadingStatus: "Carregant les dades...",
      errors: [],
      selected: [],
    };
  },
  created() {
    this.selectIncidencies();
  },
  mounted() {
    console.log("Incidencies component mounted.");
  },
  methods: {
    //   SELECT - GET   //
    selectIncidencies() {
      let me = this;

      axios
        .get("/incidencies")
        .then((response) => {
          me.incidencies = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loadingStatus = error;
        });
    },


    //   DELETE   //
    deleteIncidencies() {
      let me = this;

      me.selected.forEach((incidencia) => {
        axios
          .delete("/incidencies/" + incidencia.id)
          .then((response) => {
            console.log(response);
            me.selectIncidencies();
            me.hideModal("delete-modal");
          })
          .catch((error) => {
            console.log(error.response);
            console.log(error.response.data.errorMessage);
          });
      });
    },
  },
  computed: {
    rows() {
      return this.incidencies.length;
    },
  },
};
</script>
