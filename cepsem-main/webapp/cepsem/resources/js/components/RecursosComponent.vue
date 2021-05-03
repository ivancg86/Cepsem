<template>
  <div>
    <h1 class="page-title">RECURSOS</h1>

    <div class="d-flex justify-content-end mb-4">
      <button
        class="button button-icon button--pink"
        style="background-image: url('../assets/icons/add_white.svg')"
        id="show-btn"
        @click="afegirRecurs"
      >
        AFEGEIX UN NOU RECURS
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
     id="recursos-table"
        :fields="fields"
        :items="recursos"
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
          <svg
            @click="editRecurs"
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
        <template #cell(actiu)="data">
          <div v-if="data.item.actiu">
            <input type="checkbox" checked>
            </div>
            <div v-else>
              <input type="checkbox">
            </div>
        </template>
      </b-table>

      <b-pagination
        class="mt-5"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="recursos-table"
      ></b-pagination>

    </div>

    <b-modal hide-footer hide-header centered size="md" ref="recurs-modal">
      <div class="cepsem-modal">
        <h2 class="mb-4">RECURS</h2>
        <form>
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="input input--col mb-4">
                  <label for="codi">Codi</label>
                  <input
                    type="text"
                    name="codi"
                    id="codi"
                    placeholder="Introdueix el codi..."
                    v-model="recurs.codi"
                    autofocus
                  />
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input input--col mb-4">
                  <label for="rol">Tipus</label>
                  <b-form-select
                    name="tipus"
                    id="tipus"
                    v-model="recurs.tipus_recursos_id"
                    class="select"
                    value-field="id"
                    text-field="tipus"
                    :options="tipusrecursos"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6" >
                <div class="input input--col mb-4">
                 <label class="col-form-check-label" for="actiu">Actiu</label>
                        <input
                        class="form-check-input"
                        type="checkbox"
                        id="actiu"
                        name="actiu"
                        v-model="recurs.actiu"
                        value="actiu">
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
                @click="hideModal('recurs-modal')"
                type="button"
              >
                Cancel·lar
              </button>
            </div>
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
          <p>Estàs segur que vols esborrar els següents recursos?</p>
          <ul>
            <li v-for="(recurs, index) in selected" :key="index">
              {{ recurs.tipus_recurs.tipus + " " }}
              <span v-if="recurs.codi">{{ recurs.codi }}</span>

            </li>
          </ul>
        </div>

        <div class="cepsem-modal-footer">
          <button
            class="button button-icon button--rounded button--blue"
            type="button"
            style="background-image: url('../assets/icons/check.svg')"
            @click="deleteRecursos"
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
    tipusrecursos: {
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
      recursos: [],
      editClick: false,
      insert: false,
      recurs: {
        id: "",
        codi: "",
        actiu: false,
        tipus_recursos_id: "",
      },
      fields: [
          "selected",
        { key: "id", label: "ID", sortable: true },
        { key: "codi", label: "Codi", sortable: true },
        { key: "tipus_recurs.tipus", label: "Tipus", sortable: true },
        { key: "actiu", label: "Actiu", sortable: true, formatter: (value, key, item) => {
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
        "Editar",
      ],
      loading: true,
      loadingStatus: "Carregan les dades...",
      errors: [],
      selected: [],
    };
  },

  created() {
    this.selectRecursos();

  },
  mounted() {
    console.log("Recurs component mounted.");
  },
  methods: {
    //   SELECT - GET   //
    selectRecursos() {
      let me = this;

      axios
        .get("/recursos")
        .then((response) => {
          me.recursos = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loadingStatus = error;
        });
    },

    //   INSERT - POST   //
    insertRecurs() {
      let me = this;

      axios
        .post("/recursos", me.recurs)
        .then((response) => {
          console.log(response);

          if (response.status == 201) {
            me.selectRecursos();
            me.emptyRecurs();
            me.errors = [];
            me.hideModal("recurs-modal");
          }
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

     //   UPDATE - PUT   //
    updateRecurs() {
      let me = this;

      axios
        .put("/recursos/" + me.recurs.id,me.recurs)
        .then((response) => {
          console.log(response);
          me.selectRecursos();
          me.hideModal("recurs-modal");
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
        });
    },

    //   DELETE   //
    deleteRecursos() {
      let me = this;

      me.selected.forEach((recurs) => {
        axios
          .delete("/recursos/" + recurs.id)
          .then((response) => {
            console.log(response);
            me.selectRecursos();
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
     * Funció que fa control d'errors i redirecciona a la funcio insertUsuari() en cas d'OK
     */
    checkNotNull() {
      this.errors = [];

      if (!this.recurs.codi) {
        this.checkIfExistsError("El camp codi és obligatori.");
      }

      if (!this.recurs.tipus_recursos_id) {
        this.checkIfExistsError("El camp tipus és obligatori.");
      }


      //
      if (this.errors.length == 0) {
        if (this.insert) {
          this.insertRecurs();
        } else {
          this.updateRecurs();
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
     * Funció per a buidar els camps del objecte recurs (associat al formulari amb v-model)
     */
    emptyRecurs() {
        this.recurs.id = '',
        this.recurs.codi = '';
        this.recurs.tipus_recursos_id = '';
        this.recurs.actiu = false;
    },

    afegirRecurs() {
      this.insert = true;
      //   this.clearSelected();
      this.emptyRecurs();
      this.selectRecursos();
      this.showModal("recurs-modal");
    },

    editRecurs() {
      this.editClick = true;

      if (this.insert) {
        this.insert = false;
      }
    },

    /**
     * Funció que recupera l'últim recursos seleccionat
     *
     * @param {Array} oldarray Array que conté els recursos seleccionats excepte l'últim que s'acaba de seleccionar
     * @param {Array} newarray Array que conté els recursos seleccionats amb l'últim que s'acaba de seleccionar
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
          this.recurs = newarray[i];
          found = true;
        }

        i++;
      }
    },

    //   TABLE   //
    onRowSelected(items) {
      if (this.editClick) {
        this.getLastSelected(this.selected, items);
        this.showModal("recurs-modal");
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
      return this.recursos.length;
    },
  },
};
</script>
