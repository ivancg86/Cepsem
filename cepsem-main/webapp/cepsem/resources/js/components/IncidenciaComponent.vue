<template>
  <div>
    <h1 class="page-title">INCIDÈNCIES</h1>

    <div class="d-flex justify-content-end mb-4">
      <a
        href="/cepsem/webapp/cepsem/public/cecos/incidencia/-1"
        class="button button-icon button--pink"
        style="background-image: url('../assets/icons/add_white.svg')"
        id="show-btn"
      >
        AFEGEIX UNA NOVA INCIDÈNCIA
      </a>
    </div>

    <div v-if="loading" class="table-loading">
      <p>{{ loadingStatus }}</p>
      <div class="progress-line"></div>
    </div>

    <div v-else class="animate__animated animate__fadeIn">
      <div class="row">
        <div class="table-header">
          <div>
            <button size="sm" class="button" @click="selectAllRows">
              SELECCIONAR TOTS
            </button>
            <button size="sm" class="button ml-2" @click="clearSelected">
              DESSELECCIONAR TOTS
            </button>
          </div>

          <button class="button button-icon" @click="showModal('delete-modal')">
            ELIMINAR ({{ selected.length }})
          </button>
        </div>
      </div>

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
        @row-selected="onRowSelected"
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

        <template #cell(Editar)="data">
          <a :href="'/cepsem/webapp/cepsem/public/cecos/incidencia/' + data.item.id ">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              height="24px"
              viewBox="0 0 24 24"
              width="24px"
              fill="#11AEBF"
            >
              <path d="M0 0h24v24H0V0z" fill="none" />
              <path
                d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"
              />
            </svg>
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

    <b-modal hide-footer hide-header centered size="lg" ref="delete-modal">
      <div class="cepsem-modal">
        <div class="modal-header">
          <h2>ESBORRAR</h2>
        </div>

        <div class="modal-body">
          <p>Estàs segur que vols esborrar les següents incidències?</p>
          <ul>
            <li v-for="(incidencia, index) in selected" :key="index">
              {{
                incidencia.tipus_incidencia.tipus +
                " a " +
                incidencia.adreca +
                " (" +
                incidencia.municipi.nom +
                ", " +
                incidencia.municipi.comarca.nom +
                ", " +
                incidencia.municipi.comarca.provincia.nom +
                ") el " +
                incidencia.data +
                " a les " +
                incidencia.hora +
                " (ID " +
                incidencia.id +
                ")"
              }}
            </li>
          </ul>
        </div>

        <div class="cepsem-modal-footer">
          <button
            class="button button-icon button--rounded button--blue"
            type="button"
            style="background-image: url('../assets/icons/check.svg')"
            @click="deleteIncidencies"
          >
            Eliminar
          </button>
          <button
            class="button button-icon button--rounded button-inverted button-inverted--red ml-2 mt-3"
            block
            @click="hideModal('delete-modal')"
            type="button"
          >
            Cancel·lar
          </button>
        </div>
      </div>
    </b-modal>
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
        "Seleccionat",
        { key: "id", label: "ID", sortable: true },
        { key: "num_incident", label: "Num. Incident", sortable: true },
        { key: "data", label: "Data", sortable: true },
        { key: "hora", label: "Hora", sortable: true },
        { key: "telefon_alertant", label: "Tlf. Alertant", sortable: true },
        { key: "adreca", label: "Adreça", sortable: true },
        { key: "adreca_complement", label: "Adreça Comp.", sortable: true },
        { key: "descripcio", label: "Descripció", sortable: true },
        { key: "nom_metge", label: "Metge", sortable: true },
        { key: "tipus_incidencia.tipus", label: "Tipus", sortable: true },
        { key: "municipi.nom", label: "Municipi", sortable: true },
        "Editar",
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

    //   UTILS   //

    // /**
    //  * Funció per a buidar els camps del objecte alertant (associat al formulari amb v-model)
    //  */
    // emptyAlertant() {
    //   this.alertant.id = "";
    //   this.alertant.nom = "";
    //   this.alertant.cognoms = "";
    //   this.alertant.telefon = "";
    //   this.alertant.adreca = "";
    //   this.alertant.municipi = "";
    //   this.alertant.tipus_alertant = "";
    //   this.alertant.municipis_id = "";
    //   this.alertant.tipus_alertants_id = "";
    // },


    // /**
    //  * Funció que recupera l'últim alertant seleccionat
    //  *
    //  * @param {Array} oldarray Array que conté els alertants seleccionats excepte l'últim que s'acaba de seleccionar
    //  * @param {Array} newarray Array que conté els alertants seleccionats amb l'últim que s'acaba de seleccionar
    //  */
    // getLastSelected(oldarray, newarray) {
    //   let found = false;
    //   let inarray = false;
    //   let i = 0,
    //     j = 0;
    //   //   debugger;

    //   while (!found && i < newarray.length) {
    //     j = 0;
    //     inarray = false;

    //     while (!inarray && j < oldarray.length) {
    //       if (oldarray[j].id == newarray[i].id) {
    //         inarray = true;
    //       }
    //       j++;
    //     }

    //     if (!inarray) {
    //       this.alertant = newarray[i];
    //       found = true;
    //     }

    //     i++;
    //   }
    // },

    //   TABLE   //
    onRowSelected(items) {
    //   if (this.editClick) {
    //     this.getLastSelected(this.selected, items);
    //     this.editClick = false;
    //   }

      this.selected = items;
    },

    selectAllRows() {
      this.$refs.selectableTable.selectAllRows();
    },
    clearSelected() {
      this.$refs.selectableTable.clearSelected();
    },

    //   MODALS   //
    showModal(modal) {
      this.$refs[modal].show();
    },
    hideModal(modal) {
      this.$refs[modal].hide();
    },
  },
  computed: {
    rows() {
      return this.incidencies.length;
    },
  },
};
</script>
