<template>
  <div>
    <h1 class="page-title">USUARIS</h1>

    <div class="d-flex justify-content-end mb-4">
      <button
        class="button button-icon button--pink"
        style="background-image: url('../assets/icons/add_white.svg')"
        id="show-btn"
        @click="afegirUsuari"
      >
        AFEGEIX UN NOU USUARI
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
        id="usuaris-table"
        :fields="fields"
        :items="usuaris"
        :per-page="perPage"
        :current-page="currentPage"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        ref="selectableTable"
        sort-icon-left
        selectable
        large
        hover
        @row-selected="onRowSelected"
      >
      <template #cell(selected)="{ rowSelected }">
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
            <svg @click="editUsuari" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#11AEBF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"/></svg>
        </template>
      </b-table>

      <b-pagination
        class="mt-5"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="usuaris-table"
      ></b-pagination>

    </div>

    <b-modal hide-footer hide-header centered size="lg" ref="usuari-modal">
      <div class="cepsem-modal">
        <h2 class="mb-4">USUARI</h2>
        <form>
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="username">Usuari</label>
                  <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Introdueix el usuari de l'usuari..."
                    v-model="usuari.username"
                    autofocus
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="contrasenya">Contrasenya</label>
                  <input
                    type="password"
                    name="contrasenya"
                    id="contrasenya"
                    v-model="usuari.contrasenya"
                    placeholder="Introdueix la contrasenya de l'usuari..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    name="email"
                    id="email"
                    v-model="usuari.email"
                    placeholder="Introdueix el email de l'usuari..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="nom">Nom</label>
                  <input
                    type="text"
                    name="nom"
                    id="nom"
                    v-model="usuari.nom"
                    placeholder="Introdueix el nom de l'usuari..."
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
                    v-model="usuari.cognoms"
                    placeholder="Introdueix els cognoms de l'usuari..."
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-4">
                  <label for="rol">Rol</label>
                  <b-form-select
                    name="rol"
                    id="rol"
                    v-model="usuari.rols_id"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    :options="rols"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6" v-if="usuari.rols_id == 3">
                <div class="input input--col mb-4">
                  <label for="recurs">Recurs</label>
                  <b-form-select
                    name="recurs"
                    id="recurs"
                    v-model="usuari.recursos_id"
                    class="select"
                    value-field="id"
                    text-field="codi"
                    :options="recursos"
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
                @click="checkNotNull">
                <span v-if="insert">Afegir</span>
                <span v-else>Modificar</span>
              </button>
              <button
                class="button button-icon button--rounded button-inverted button-inverted--red ml-2 mt-3"
                block
                @click="hideModal('usuari-modal')"
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
          <p>Estàs segur que vols esborrar els següents usuaris?</p>
          <ul>
            <li v-for="(usuari, index) in selected" :key="index">
              {{ usuari.id + " " }}
              <span v-if="usuari.nom">{{ usuari.nom }}</span>
              <span v-if="usuari.cognoms">{{ usuari.cognoms }}</span>
            </li>
          </ul>
        </div>

        <div class="cepsem-modal-footer">
          <button
            class="button button-icon button--rounded button--blue"
            type="button"
            style="background-image: url('../assets/icons/check.svg')"
            @click="deleteUsuaris"
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
    recursos: {
      type: Array,
      required: false,
    },

    rols: {
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
      usuaris: [],
      editClick: false,
      insert: false,
      usuari: {
        id: "",
        username: "",
        contrasenya: "",
        email: "",
        nom: "",
        cognoms: "",
        rols_id: "",
        recursos_id: "",

      },
      fields: [
          "selected",
        { key: "id", label: "ID", sortable: true },
        { key: "username", label: "Usuari", sortable: true },
        { key: "contrasenya", label: "Contrasenya", sortable: true },
        { key: "email", label: "Email", sortable: true },
        { key: "nom", label: "Nom", sortable: true },
        { key: "cognoms", label: "Cognoms", sortable: true },
        { key: "rol.nom", label: "Rol", sortable: true },
        { key: "recurs.codi", label: "Recurs", sortable: true },
         "Editar",
      ],
      loading: true,
      loadingStatus: "Carregant les dades...",
      errors: [],
      selected: [],
    };
  },
  created() {
    this.selectUsuaris();

  },
  mounted() {
    console.log("Usuari component mounted.");
  },
  methods: {
    //   SELECT - GET   //
    selectUsuaris() {
      let me = this;

      axios
        .get("/usuaris")
        .then((response) => {
          me.usuaris = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loadingStatus = error;
        });
    },

    //   INSERT - POST   //
    insertUsuari() {
      let me = this;

      axios
        .post("/usuaris", me.usuari)
        .then((response) => {
          console.log(response);

          if (response.status == 201) {
            me.selectUsuaris();
            me.emptyUsuari();
            me.errors = [];
            me.hideModal("usuari-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },
    updateUsuari(){
        let me = this;

      axios
        .put("/usuaris/" + me.usuari.id, me.usuari)
        .then((response) => {
          console.log(response);

          if (response.status == 204) {
            me.selectUsuaris();
            me.emptyUsuari();
            me.errors = [];
            me.hideModal("usuari-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },
    //   DELETE   //
    deleteUsuaris() {
      let me = this;

      me.selected.forEach((usuari) => {
        axios
          .delete("/usuaris/" + usuari.id)
          .then((response) => {
            console.log(response);
            me.selectUsuaris();
            me.hideModal("delete-modal");
          })
          .catch((error) => {
            console.log(error.response);
            console.log(error.response.data.errorMessage);
          });
      });
    },
    afegirUsuari() {
      this.insert = true;
      this.emptyUsuari();
      this.selectUsuaris();
      this.showModal("usuari-modal");
    },
    editUsuari(){
        this.editClick = true;

      if (this.insert) {
        this.insert = false;
      }
    },
    onRowSelected(items) {
      if (this.editClick) {
        this.getLastSelected(this.selected, items);
        this.showModal("usuari-modal");
        this.editClick = false;
      }

      this.selected = items;
    },
    editButtonClick(){
        this.editClick = true;
    },
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
          this.usuari = newarray[i];
          found = true;
        }

        i++;
      }
    },
    selectAllRows() {
      this.$refs.selectableTable.selectAllRows();
    },
    clearSelected() {
      this.$refs.selectableTable.clearSelected();
    },
    //   UTILS   //

    /**
     * Funció que fa control d'errors i redirecciona a la funcio insertUsuari() en cas d'OK
     */
    checkNotNull() {
      this.errors = [];

      if (!this.usuari.username) {
        this.checkIfExistsError("El camp usuari és obligatori.");
      }

      if (!this.usuari.contrasenya) {
        this.checkIfExistsError("El camp contrasenya és obligatori.");
      }

      if (!this.usuari.email) {
        this.checkIfExistsError("El camp email és obligatori.");
      }

      if (!this.usuari.nom) {
        this.checkIfExistsError("El camp nom és obligatori.");
      }

      if (!this.usuari.cognoms) {
        this.checkIfExistsError("El camp cognoms és obligatori.");
      }

      if (!this.usuari.rols_id) {
        this.checkIfExistsError("El camp rol és obligatori.");
      }

      //
      if (this.errors.length == 0) {
        if (this.insert) {
          this.insertUsuari();
        } else {
          this.updateUsuari();
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
    emptyUsuari() {
        this.usuari.id = '',
        this.usuari.username = '';
        this.usuari.contrasenya = '';
        this.usuari.email = '';
        this.usuari.nom = '';
        this.usuari.cognoms = '';
        this.usuari.rols_id = '';
        this.usuari.recursos_id = '';
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
      return this.usuaris.length;
    },
  },
};
</script>
