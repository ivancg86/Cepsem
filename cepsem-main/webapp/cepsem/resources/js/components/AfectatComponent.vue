<template>
  <div>
    <h1 class="page-title">AFECTATS</h1>

    <div class="d-flex justify-content-end mb-4">
      <button
        class="button button-icon button--pink"
        style="background-image: url('../assets/icons/add_white.svg')"
        id="show-btn"
        @click="afegirAfectat"
      >
        AFEGEIX UN NOU AFECTAT
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
        id="afectats-table"
        :fields="fields"
        :items="afectats"
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
            @click="editAfectat"
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

        <template #cell(te_cip)="data">
          <div v-if="data.item.te_cip">
            <input type="checkbox" checked disabled>
            </div>
            <div v-else>
              <input type="checkbox" disabled>
            </div>
        </template>
      </b-table>

      <b-pagination
        class="mt-5"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="afectats-table"
      ></b-pagination>
    </div>

    <b-modal hide-footer hide-header centered size="lg" ref="afectat-modal">
      <div class="cepsem-modal">
        <h2 class="mb-4">AFECTAT</h2>
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
                    placeholder="Introdueix el nom de l'afectat..."
                    v-model="afectat.nom"
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
                    v-model="afectat.cognoms"
                    placeholder="Introdueix els cognoms de l'afectat..."
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
                    v-model="afectat.telefon"
                    placeholder="Introdueix el telèfon de l'afectat..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="edat">Edat</label>
                  <input
                    type="number"
                    name="edat"
                    id="edat"
                    v-model="afectat.edat"
                    placeholder="Introdueix l'edat de l'afectat..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="cip">Cip</label>
                  <input
                    type="text"
                    name="cip"
                    id="cip"
                    v-model="afectat.cip"
                    placeholder="Introdueix el cip de l'afectat..."
                  />
                </div>
              </div>

              <div class="col-lg-6" >
                <div class="input input--col mb-4">
                 <label class="col-form-check-label" for="te_cip">Te cip</label>
                        <input
                        class="form-check-input"
                        type="checkbox"
                        id="te_cip"
                        name="te_cip"
                        v-model="afectat.te_cip"
                        value="te_cip">
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="sexe">Sexe</label>
                  <b-form-select
                    name="sexe"
                    id="sexe"
                    class="select"
                    value-field="id"
                    text-field="sexe"
                    :options="sexes"
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
                @click="hideModal('afectat-modal')"
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
          <p>Estàs segur que vols esborrar els següents afectats?</p>
          <ul>
            <li v-for="(afectat, index) in selected" :key="index">
              <span v-if="afectat.nom">{{ afectat.nom }}</span>
              <span v-if="afectat.cognoms">{{ afectat.cognoms }}</span> amb
              tlf. {{ afectat.telefon }}
            </li>
          </ul>
        </div>

        <div class="cepsem-modal-footer">
          <button
            class="button button-icon button--rounded button--blue"
            type="button"
            style="background-image: url('../assets/icons/check.svg')"
            @click="deleteAfectats"
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
    sexes: {
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
      afectats: [],
      editClick: false,
      insert: false,
      afectat: {
        id: "",
        telefon: "",
        cip: "",
        nom: "",
        cognoms: "",
        edat: "",
        te_cip: "",
        sexes_id: "",
      },
      fields: [
        "Seleccionat",
        { key: "id", label: "ID", sortable: true },
        { key: "telefon", label: "Telèfon", sortable: true },
        { key: "cip", label: "CIP", sortable: true },
        { key: "nom", label: "Nom", sortable: true },
        { key: "cognoms", label: "Cognoms", sortable: true },
        { key: "edat", label: "Edat", sortable: true },
        { key: "te_cip", label: "Te CIP", sortable: true, formatter: (value, key, item) => {
            if(value==1)
              {
                return true
              }
            else
              {
                return false
              }
            }
        },
        { key: "sexe.sexe", label: "Sexe", sortable: true },
        "Editar",
      ],
      loading: true,
      loadingStatus: "Carregant les dades...",
      errors: [],
      selected: [],
    };
  },
  created() {
    this.selectAfectats();
  },
  mounted() {
    console.log("Afectat component mounted.");
  },
  methods: {
    //   SELECT - GET   //
    selectAfectats() {
      let me = this;

      axios
        .get("/afectats")
        .then((response) => {
          me.afectats = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loadingStatus = error;
        });
    },

    //   INSERT - POST   //
    insertAfectat() {
      let me = this;

      axios
        .post("/afectats", me.afectat)
        .then((response) => {
          console.log(response);

          if (response.status == 201) {
            me.selectAfectats();
            me.emptyAfectat();
            me.errors = [];
            me.hideModal("afectat-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

    //   UPDATE - PUT   //
    updateAfectat() {
      let me = this;
      axios
        .put("/afectats/" + me.afectat.id, me.afectat)
        .then((response) => {
          console.log(response);

          if (response.status == 204) {
            me.selectAfectats();
            me.emptyAfectat();
            me.errors = [];
            me.hideModal("afectat-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

    //   DELETE   //
    deleteAfectats() {
      let me = this;

      me.selected.forEach((afectat) => {
        axios
          .delete("/afectats/" + afectat.id)
          .then((response) => {
            console.log(response);
            me.selectAfectats();
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

      if (this.afectat.telefon.toString) {
        if (this.afectat.telefon.toString().length != 9) {
          this.checkIfExistsError("El camp telèfon ha d'incloure 9 números");
        }
      } else {
        this.checkIfExistsError("El camp telèfon és obligatori.");
      }

      if (!this.afectat.sexes_id) {
        this.checkIfExistsError("El camp sexe és obligatori.");
      }

      if (this.errors.length == 0) {
        if (this.insert) {
          this.insertAfectat();
        } else {
          this.updateAfectat();
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
    emptyAfectat() {
      this.afectat.id = "";
      this.afectat.telefon = "";
      this.afectat.cip = "";
      this.afectat.nom = "";
      this.afectat.cognoms = "";
      this.afectat.edat = "";
      this.afectat.te_cip = "";
      this.afectat.sexes_id = "";
    },

    afegirAfectat() {
      this.insert = true;
      //   this.clearSelected();
      this.emptyAfectat();
      this.selectAfectats();
      this.showModal("afectat-modal");
    },

    editAfectat() {
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
          this.afectat = newarray[i];
          found = true;
        }

        i++;
      }
    },

    //   TABLE   //
    onRowSelected(items) {
      if (this.editClick) {
        this.getLastSelected(this.selected, items);
        this.showModal("afectat-modal");
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
      return this.afectats.length;
    },
  },
};
</script>
