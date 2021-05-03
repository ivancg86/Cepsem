<template>
  <div>
    <h1 class="page-title">ALERTANTS</h1>

    <div class="d-flex justify-content-end mb-4">
      <button
        class="button button-icon button--pink"
        style="background-image: url('../assets/icons/add_white.svg')"
        id="show-btn"
        @click="afegirAlertant"
      >
        AFEGEIX UN NOU ALERTANT
      </button>
    </div>

    <div v-if="loading" class="table-loading">
      <p>{{ loadingStatus }}</p>
      <div class="progress-line"></div>
    </div>

    <div v-else class="animate__animated animate__fadeIn">
      <div class="row">
        <div class="table-header">
          <div>
            <button size="sm" class="button" @click="selectAllRows">SELECCIONAR TOTS</button>
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
        id="alertants-table"
        :fields="fields"
        :items="alertants"
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

        <template #cell(Editar)>
          <svg
            @click="editAlertant"
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

    <b-modal hide-footer hide-header centered size="lg" ref="alertant-modal">
      <div class="cepsem-modal">
        <h2 class="mb-4">ALERTANT</h2>
        <form>
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="nom">Nom</label>
                  <input
                    type="text"
                    name="nom"
                    id="nom"
                    placeholder="Introdueix el nom de l'alertant..."
                    v-model="alertant.nom"
                    autofocus
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="cognoms">Cognoms</label>
                  <input
                    type="text"
                    name="cognoms"
                    id="cognoms"
                    v-model="alertant.cognoms"
                    placeholder="Introdueix els cognoms de l'usuari..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="telefon">Telèfon</label>
                  <input
                    type="number"
                    min="600000000"
                    max="999999999"
                    name="telefon"
                    id="telefon"
                    v-model="alertant.telefon"
                    placeholder="Introdueix el telèfon de l'alertant..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="adreca">Adreça</label>
                  <input
                    type="text"
                    name="adreca"
                    id="adreca"
                    v-model="alertant.adreca"
                    placeholder="Introdueix l'adreça de l'alertant..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="tipus">Tipus</label>
                  <b-form-select
                    name="tipus"
                    id="tipus"
                    v-model="alertant.tipus_alertants_id"
                    class="select"
                    value-field="id"
                    text-field="tipus"
                    :options="tipusalertants"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="provincia">Provincia</label>
                  <b-form-select
                    name="provincia"
                    id="provincia"
                    v-model="alertant.municipi.comarca.provincia.id"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    :options="provincies"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="comarca">Comarca</label>
                  <b-form-select
                    name="comarca"
                    id="comarca"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    v-model="alertant.municipi.comarca.id"
                    :options="comarques"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="municipi">Municipi</label>
                  <b-form-select
                    name="municipi"
                    id="municipi"
                    v-model="alertant.municipis_id"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    :options="municipis"
                  ></b-form-select>
                </div>
              </div>
            </div>

            <div
              v-show="errors.length"
              class="input-error input-error--show"
              style="margin-bottom: 0"
            >
              <img
                src="/cepsem/webapp/cepsem/public/assets/icons/alert.svg"
                alt=""
                width="18px"
                height="18px"
                style="margin-bottom: auto"
              />
              <div style="display: flex; flex-direction: column">
                <span>Petició invàlida, corregeix els següents errors:</span>
                <ul>
                  <li v-for="(error, index) in errors" :key="index">
                    {{ error }}
                  </li>
                </ul>
              </div>
            </div>

            <div class="cepsem-modal-footer">
              <button
                class="button button-icon button--rounded button--blue"
                type="button"
                style="background-image: url('../assets/icons/check.svg')"
                @click="checkNotNull"
              >
                <span v-if="insert">Afegir</span>
                <span v-else>Modificar</span>
              </button>
              <button
                class="button button-icon button--rounded button-inverted button-inverted--red ml-2 mt-3"
                block
                @click="hideModal('alertant-modal')"
                type="button">
                Cancel·lar
              </button>
            </div>
          </div>
        </form>
      </div>
    </b-modal>

    <b-modal hide-footer hide-header centered size="lg" ref="delete-modal">
      <div class="cepsem-modal">
        <div class="modal-header">
          <h2>ESBORRAR</h2>
        </div>

        <div class="modal-body">
          <p>Estàs segur que vols esborrar els següents alertants?</p>
          <ul>
            <li v-for="(alertant, index) in selected" :key="index">
              {{ alertant.tipus_alertant.tipus + " " }}
              <span v-if="alertant.nom">{{ alertant.nom }}</span>
              <span v-if="alertant.cognoms">{{ alertant.cognoms }}</span> amb
              tlf. {{ alertant.telefon }}
            </li>
          </ul>
        </div>

        <div class="cepsem-modal-footer">
          <button
            class="button button-icon button--rounded button--blue"
            type="button"
            style="background-image: url('../assets/icons/check.svg')"
            @click="deleteAlertants"
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
  props: {
    tipusalertants: {
      type: Array,
      required: false,
    },

    provincies: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      sortBy: "id",
      sortDesc: false,
      perPage: 10,
      currentPage: 1,
      alertants: [],
      editClick: false,
      insert: false,
      loading: true,
      loadingStatus: "Carregant les dades...",
      errors: [],
      selected: [],

      alertant: {
        id: 0,
        telefon: "",
        nom: "",
        cognoms: "",
        adreca: "",
        municipis_id: 0,
        tipus_alertants_id: 0,
        incidencies: [],
        tipus_alertant: {
          id: 0,
          tipus: "",
        },
        municipi: {
          id: 0,
          nom: "",
          comarques_id: 0,
          comarca: {
            id: 0,
            nom: "",
            provincies_id: 0,
            provincia: {
              id: 0,
              nom: "",
            },
          },
        },
      },

      fields: [
        "Seleccionat",
        { key: "id", label: "ID", sortable: true },
        { key: "telefon", label: "Telèfon", sortable: true },
        { key: "nom", label: "Nom", sortable: true },
        { key: "cognoms", label: "Cognoms", sortable: true },
        { key: "adreca", label: "Adreça", sortable: true },
        { key: "municipi.nom", label: "Municipi", sortable: true },
        { key: "municipi.comarca.nom", label: "Comarca", sortable: true },
        {
          key: "municipi.comarca.provincia.nom",
          label: "Provincia",
          sortable: true,
        },
        { key: "tipus_alertant.tipus", label: "Tipus", sortable: true },
        "Editar",
      ],
    };
  },
  created() {
    this.selectAlertants();
  },
  mounted() {
    console.log("Alertant component mounted.");
  },
  methods: {
    //   SELECT - GET   //
    selectAlertants() {
      let me = this;

      axios
        .get("/alertants")
        .then((response) => {
          me.alertants = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loadingStatus = error;
        });
    },

    //   INSERT - POST   //
    insertAlertant() {
      let me = this;

      axios
        .post("/alertants", me.alertant)
        .then((response) => {
          console.log(response);

          if (response.status == 201) {
            me.selectAlertants();
            me.emptyAlertant();
            me.errors = [];
            me.hideModal("alertant-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

    //   UPDATE - PUT   //
    updateAlertant() {
      let me = this;
      axios
        .put("/alertants/" + me.alertant.id, me.alertant)
        .then((response) => {
          console.log(response);

          if (response.status == 204) {
            me.selectAlertants();
            me.emptyAlertant();
            me.errors = [];
            me.hideModal("alertant-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

    //   DELETE   //
    deleteAlertants() {
      let me = this;

      me.selected.forEach((alertant) => {
        axios
          .delete("/alertants/" + alertant.id)
          .then((response) => {
            console.log(response);
            me.selectAlertants();
            me.hideModal("delete-modal");
          })
          .catch((error) => {
            console.log(error.response);
            console.log(error.response.data.errorMessage);
          });
      });
    },

    //   UTILS   //
    /**
     * Funció que fa control d'errors i redirecciona a la funcio insertAlertant() o updateAlertant() en cas d'OK
     */
    checkNotNull() {
      this.errors = [];

      if (this.alertant.telefon) {
        if (this.alertant.telefon.toString().length != 9) {
          this.checkIfExistsError("El camp telèfon ha d'incloure 9 números");
        }
      } else {
        this.checkIfExistsError("El camp telèfon és obligatori.");
      }

      if (!this.alertant.tipus_alertants_id) {
        this.checkIfExistsError("El camp tipus és obligatori.");
      }

      if (this.errors.length == 0) {
        if (this.insert) {
          this.insertAlertant();
        } else {
          this.updateAlertant();
        }
      }
    },

    /**
     * Funció que rep un missatge d'error per paràmetre, si no existeix a la llista d'errors l'afegirà
     *
     * @param {String} errorMessage
     */
    checkIfExistsError(errorMessage) {
      if (!this.errors.includes(errorMessage)) {
        this.errors.push(errorMessage);
      }
    },

    /**
     * Funció per a buidar els camps del objecte alertant (associat al formulari amb v-model)
     */
    emptyAlertant() {
      this.alertant.id = 0;
      this.alertant.nom = "";
      this.alertant.cognoms = "";
      this.alertant.telefon = "";
      this.alertant.adreca = "";
      this.alertant.incidencies = [];
      this.alertant.municipis_id = 0;
      this.alertant.tipus_alertants_id = 0;
      this.alertant.tipus_alertant.id = 0;
      this.alertant.tipus_alertant.tipus = "";
      this.alertant.municipi.id = 0;
      this.alertant.municipi.nom = "";
      this.alertant.municipi.comarques_id = 0;
      this.alertant.municipi.comarca.id = 0;
      this.alertant.municipi.comarca.nom = "";
      this.alertant.municipi.comarca.provincies_id = 0;
      this.alertant.municipi.comarca.provincia.id = 0;
      this.alertant.municipi.comarca.provincia.nom = "";
    },

    afegirAlertant() {
      this.insert = true;
      //   this.clearSelected();
      this.selectAlertants();
      this.showModal("alertant-modal");
      this.emptyAlertant();
    },

    editAlertant() {
      this.editClick = true;

      if (this.insert) {
        this.insert = false;
      }
    },

    /**
     * Funció que recupera l'últim alertant seleccionat
     *
     * @param {Array} oldarray Array que conté els alertants seleccionats excepte l'últim que s'acaba de seleccionar
     * @param {Array} newarray Array que conté els alertants seleccionats amb l'últim que s'acaba de seleccionar
     */
    getLastSelected(oldarray, newarray) {
      let found = false;
      let inarray = false;
      let i = 0,
        j = 0;
      //   debugger;

      while (!found && i < newarray.length) {
        j = 0;
        inarray = false;

        while (!inarray && j < oldarray.length) {
          if (oldarray[j].id == newarray[i].id) {
            inarray = true;
          }
          j++;
        }

        if (!inarray) {
          this.alertant = newarray[i];
          found = true;
        }

        i++;
      }
    },


    //   TABLE   //
    onRowSelected(items) {
      if (this.editClick) {
        this.getLastSelected(this.selected, items);
        this.showModal("alertant-modal");
        this.editClick = false;
      }

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
      return this.alertants.length;
    },

    comarques() {
      let comarques = [];
      // comarques.push({ id: 0, nom: "Selecciona la comarca" });
      let alertantProvincia = this.alertant.municipi.comarca.provincia.id;
      if (alertantProvincia == 0) {
        this.provincies.forEach((provincia) => {
          provincia.comarques.forEach((comarca) => {
            comarques.push(comarca);
          });
        });
      } else {
        this.provincies.forEach((provincia) => {
          if (provincia.id == alertantProvincia) {
            provincia.comarques.forEach((comarca) => {
              comarques.push(comarca);
            });
          }
        });
      }

      return comarques;
    },

    municipis() {
      let municipis = [];
      let alertantComarca = this.alertant.municipi.comarca.id;

      if (alertantComarca == 0) {
        this.comarques.forEach((comarca) => {
          comarca.municipis.forEach((municipi) => {
            municipis.push(municipi);
          });
        });
      } else {
        this.comarques.forEach((comarca) => {
          if (alertantComarca == comarca.id) {
            comarca.municipis.forEach((municipi) => {
              municipis.push(municipi);
            });
          }
        });
      }

      return municipis;
    },
  },
};
</script>
