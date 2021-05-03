<template>
  <div class="container-fluid">
    <div class="incidencia-form mb-4 m-md-3 m-lg-4 m-xl-5">
      <h1 class="page-title">
        <span v-if="insert">NOVA</span><span v-else>EDITAR</span> INCIDÈNCIA
      </h1>

      <h3 class="mt-5 mr-3" style="text-align: right">
        <div id="anchor"></div>
        <b>ID {{ incidencia.id }}</b>
      </h3>

      <div v-if="loading" class="table-loading">
        <p>{{ loadingStatus }}</p>
        <div class="progress-line"></div>
      </div>

      <div v-else>
        <nav class="incidencia-form-nav table-header">
          <span class="nav-link active" @click="tabSelected(0)" data-nav="0"
            >ALERTANT</span
          >
          <span class="nav-link" @click="tabSelected(1)" data-nav="1"
            >LOCALITZACIÓ</span
          >
          <span class="nav-link" @click="tabSelected(2)" data-nav="2"
            >AFECTATS</span
          >
          <span class="nav-link" @click="tabSelected(3)" data-nav="3"
            >RECURSOS MÒBILS</span
          >
        </nav>

        <div class="incidencia-form-body">
          <section
            class="js-tab-content animate__animated animate__faster animate__fadeIn"
            id="alertant"
            data-tab="0"
          >
            <div class="row">
              <div class="col-lg-7">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="input input--col mb-4">
                      <label for="tipusaccident">Tipus Incidència</label>
                      <b-form-select
                        name="tipusaccident"
                        id="tipusaccident"
                        class="select"
                        value-field="id"
                        text-field="tipus"
                        :options="tipusincidents"
                        v-model="incidencia.tipus_incidencies_id"
                      ></b-form-select>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="input input--col mb-4">
                      <label for="numincidencia">Número Incidencia</label>
                      <input
                        type="number"
                        name="numincidencia"
                        id="numincidencia"
                        min="0"
                        v-model="incidencia.num_incident"
                        placeholder="Introdueix el número d'incidència..."
                      />
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="input input--col mb-4">
                      <label for="descripcio">Descripció</label>
                      <textarea
                        name="descripcio"
                        id="descripcio"
                        cols="30"
                        rows="4"
                        v-model="incidencia.descripcio"
                        placeholder="Dóna una descripció de l'incident..."
                      ></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-5 my-5 my-lg-0">
                <div class="incidencia-hora">
                  <div class="input input--row mb-4">
                    <label for="dataincidencia">Data</label>
                    <input
                      type="date"
                      name="dataincidencia"
                      id="dataincidencia"
                      v-model="incidencia.data"
                    />
                  </div>

                  <div class="input input--row mb-4">
                    <label for="horaincidencia">Hora</label>
                    <input
                      type="time"
                      name="horaincidencia"
                      id="horaincidencia"
                      v-model="incidencia.hora"
                    />
                  </div>

                  <div>
                    <button
                      class="button button--pink ml-2"
                      @click="actualitzarDateTime"
                    >
                      ACTUALITZAR
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row m-md-5">
              <div class="col-lg-12 mb-3">
                <h3 class="section-title">
                  <img
                    src="/cepsem/webapp/cepsem/public/assets/icons/alertant.svg"
                    alt=""
                    class="mr-3"
                  />DADES DE L'ALERTANT
                </h3>
              </div>

              <div class="col-lg-6 mb-4">
                <div class="input input--col mb-2">
                  <label for="cercaTlf">Cerca un alertant existent</label>
                  <div class="input-button">
                    <input
                      type="text"
                      name="cercaTlf"
                      id="cercaTlf"
                      v-model="cercaAlertant"
                      placeholder="Introdueix el telèfon de l'alertant..."
                      autofocus
                    />
                    <button
                      class="button button--blue"
                      style="width: 100%"
                      @click="cercaAlertantbyTlf"
                    >
                      CARREGAR DADES
                    </button>
                  </div>
                </div>
                <div
                  v-show="loadingStatus"
                  class="input-error input-error--show"
                >
                  <img
                    src="/cepsem/webapp/cepsem/public/assets/icons/alert.svg"
                    alt=""
                    width="18px"
                    height="18px"
                    style="margin-bottom: auto"
                  />
                  <span>No s'ha trobat cap resultat</span>
                </div>
              </div>

              <div class="col-lg-6"></div>

              <div class="col-lg-6 order-1">
                <div class="input input--col mb-4">
                  <label for="nomalertant">Nom</label>
                  <input
                    type="text"
                    name="nomalertant"
                    id="nomalertant"
                    placeholder="Introdueix el nom de l'alertant..."
                    v-model="incidencia.alertant.nom"
                  />
                </div>
              </div>

              <div class="col-lg-6 order-5 order-lg-2">
                <div class="input input--col mb-4">
                  <label for="adrecaAlertant">Adreça</label>
                  <input
                    type="text"
                    name="adrecaAlertant"
                    id="adrecaAlertant"
                    v-model="incidencia.alertant.adreca"
                    placeholder="Introdueix l'adreça de l'alertant..."
                  />
                </div>
              </div>

              <div class="col-lg-6 order-2 order-lg-3">
                <div class="input input--col mb-4">
                  <label for="cognomsalertant">Cognoms</label>
                  <input
                    type="text"
                    name="cognomsalertant"
                    id="cognomsalertant"
                    v-model="incidencia.alertant.cognoms"
                    placeholder="Introdueix els cognoms de l'alertant..."
                  />
                </div>
              </div>

              <div class="col-lg-6 order-6 order-lg-4">
                <div class="input input--col mb-4">
                  <label for="provinciaalertant">Provincia</label>
                  <b-form-select
                    name="provinciaalertant"
                    id="provinciaalertant"
                    v-model="incidencia.alertant.municipi.comarca.provincia.id"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    :options="provincies"
                    @change="filtrarAlertantComarques"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6 order-3 order-lg-5">
                <div class="input input--col mb-4">
                  <label for="telefonalertant">Telèfon</label>
                  <input
                    type="number"
                    min="600000000"
                    max="999999999"
                    name="telefonalertant"
                    id="telefonalertant"
                    v-model="incidencia.alertant.telefon"
                    placeholder="Introdueix el telèfon de l'alertant..."
                  />
                </div>
              </div>

              <div class="col-lg-6 order-7 order-lg-6">
                <div class="input input--col mb-4">
                  <label for="comarcaalertant">Comarca</label>
                  <b-form-select
                    name="comarcaalertant"
                    id="comarcaalertant"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    v-model="incidencia.alertant.municipi.comarca.id"
                    :options="alertantComarques"
                    @change="filtrarAlertantMunicipis"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6 order-4 order-lg-7">
                <div class="input input--col mb-4">
                  <label for="tipusalertant">Tipus</label>
                  <b-form-select
                    name="tipusalertant"
                    id="tipusalertant"
                    v-model="incidencia.alertant.tipus_alertants_id"
                    class="select"
                    value-field="id"
                    text-field="tipus"
                    :options="tipusalertants"
                  ></b-form-select>
                </div>
              </div>

              <div class="col-lg-6 order-8">
                <div class="input input--col mb-4">
                  <label for="municipialertant">Municipi</label>
                  <b-form-select
                    name="municipialertant"
                    id="municipialertant"
                    v-model="incidencia.alertant.municipis_id"
                    class="select"
                    value-field="id"
                    text-field="nom"
                    :options="alertantMunicipis"
                  ></b-form-select>
                </div>
              </div>
<!--
              <div class="col-lg-4 order-9" v-show="insert">
                <input
                  type="checkbox"
                  name="saveAlertant"
                  id="saveAlertant"
                  v-model="incidencia.saveAlertant"
                />
                <label for="saveAlertant">Emmagatzemar Alertant</label>
              </div> -->
            </div>
          </section>

          <section
            class="js-tab-content animate__animated animate__faster"
            id="localitzacio"
            data-tab="1"
            style="display: none"
          >
            <div class="row">
              <div class="col-lg-7 order-2 order-lg-1">
                <div class="row">
                  <div class="col-xl-4">
                    <div class="input input--col mb-4">
                      <label for="provinciaincidencia">Provincia</label>
                      <b-form-select
                        name="provinciaincidencia"
                        id="provinciaincidencia"
                        v-model="incidencia.municipi.comarca.provincia.id"
                        class="select"
                        value-field="id"
                        text-field="nom"
                        :options="provincies"
                        @change="filtrarIncidenciaComarques"
                      ></b-form-select>
                    </div>
                  </div>
                  <div class="col-xl-4">
                    <div class="input input--col mb-4">
                      <label for="comarcaincidencia">Comarca</label>
                      <b-form-select
                        name="comarcaincidencia"
                        id="comarcaincidencia"
                        class="select"
                        value-field="id"
                        text-field="nom"
                        v-model="incidencia.municipi.comarca.id"
                        :options="incidenciaComarques"
                        @change="filtrarIncidenciaMunicipis"
                      ></b-form-select>
                    </div>
                  </div>
                  <div class="col-xl-4">
                    <div class="input input--col mb-4">
                      <label for="municipiincidencia">Municipi</label>
                      <b-form-select
                        name="municipiincidencia"
                        id="municipiincidencia"
                        v-model="incidencia.municipis_id"
                        class="select"
                        value-field="id"
                        text-field="nom"
                        :options="incidenciaMunicipis"
                      ></b-form-select>
                    </div>
                  </div>

                  <div class="col-lg-7">
                    <div class="input input--col mb-4">
                      <label for="address">Adreça</label>
                      <input
                        type="text"
                        name="address"
                        id="address"
                        v-model="incidencia.adreca"
                        placeholder="Introdueix l'adreça de l'incident..."
                      />
                    </div>
                  </div>

                  <div class="col-lg-5 m-auto">
                    <button
                      class="button button--blue button-icon"
                      style="
                        background-image: url('/cepsem/webapp/cepsem/public/assets/icons/map.svg');
                      "
                      id="submit"
                      type="button"
                      value="Geocode"
                      @click="geocodeAddress"
                    >
                      Localitzar
                    </button>
                  </div>

                  <div class="col-lg-12">
                    <div class="input input--col mb-4">
                      <label for="complementadreca">Complement Adreça</label>
                      <textarea
                        name="complementadreca"
                        id="complementadreca"
                        cols="30"
                        rows="7"
                        v-model="incidencia.adreca_complement"
                        placeholder="Indica informació complementària sobre l’adreça del incident..."
                      ></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-5 mb-5 mb-lg-0 order-1 order-lg-2">
                <div id="map"></div>
              </div>
            </div>
          </section>

          <!--  -->
          <section
            class="js-tab-content animate__animated animate__faster"
            id="afectats"
            data-tab="2"
            style="display: none"
          >
            <div class="row">
              <afectatitem-component
                v-for="incidencia_has_recurs in incidencia.incidencia_has_recursos"
                :key="incidencia_has_recurs.afectat.id"
                :incidencia_has_recurs_afectat="incidencia_has_recurs.afectat"
                :sexes="sexes"
                @remove-afectat="removeAfectat"
              ></afectatitem-component>

              <div class="col-3 m-auto">
                <button
                  class="button button-icon button-inverted button-inverted--blue button--rounded addButton"
                  @click="addAfectat"
                >
                  Afegir Afectat
                </button>
              </div>
            </div>
          </section>

          <section
            class="js-tab-content animate__animated animate__faster"
            id="recursos"
            data-tab="3"
            style="display: none"
          >
            <recursitem-component
              v-for="incidencia_has_recurs in incidencia.incidencia_has_recursos"
              :key="incidencia_has_recurs.id"
              :incidencia_has_recurs="incidencia_has_recurs"
              :tipusrecursos="tipusrecursos"
              :sexes="sexes"
              :usuarilogin="usuari"
              :usuarirecurs="incidencia.usuari"
              :insert="insert"
            >
            </recursitem-component>
          </section>

          <div class="incidencia-form-footer">
            <a
              href="#anchor"
              class="button button-icon button--pink button--rounded"
              style="
                background-image: url('/cepsem/webapp/cepsem/public/assets/icons/next.svg');
              "
              @click="fabClick"
            >
              <span v-if="currentTab == 3">Finalitzar</span>
              <span v-else>Següent</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  props: {
    idincidencia: {
      type: Number,
      required: false,
    },
    insert: {
      type: Boolean,
      required: true,
    },
    tipusalertants: {
      type: Array,
      required: false,
    },
    tipusincidents: {
      type: Array,
      required: false,
    },
    provincies: {
      type: Array,
      required: false,
    },
    sexes: {
      type: Array,
      required: false,
    },
    tipusrecursos: {
      type: Array,
      required: false,
    },
    usuari: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      map: 0,
      mapMounted: false,
      geocoder: 0,
      alertantComarques: [],
      alertantMunicipis: [],
      incidenciaComarques: [],
      incidenciaMunicipis: [],
      cercaAlertant: "",
      currentTab: 0,
      loading: true,
      loadingStatus: "Carregant les dades...",
      incidencia: {
        id: 0,
        num_incident: 0,
        data: "yyyy-MM-dd",
        hora: "HH:mm",
        telefon_alertant: "",
        adreca: "",
        adreca_complement: "",
        descripcio: "",
        nom_metge: "",
        tipus_incidencies_id: 0,
        alertants_id: 0,
        municipis_id: 0,
        usuaris_id: this.usuari.id,
        // saveAlertant: false,
        alertant: {
          id: 0,
          telefon: "",
          nom: "",
          cognoms: "",
          adreca: "",
          municipis_id: 0,
          tipus_alertants_id: 0,
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
        incidencia_has_recursos: [],
      },
    };
  },
  created() {
    this.initComponent();

    this.alertantComarques = this.filtrarComarques(
      this.incidencia.alertant.municipi.comarca.provincia.id
    );
    this.alertantMunicipis = this.filtrarMunicipis(
      this.incidencia.alertant.municipi.comarca.id,
      this.alertantComarques
    );
    this.incidenciaComarques = this.filtrarComarques(
      this.incidencia.municipi.comarca.provincia.id
    );
    this.incidenciaMunicipis = this.filtrarMunicipis(
      this.incidencia.municipi.comarca.id,
      this.incidenciaComarques
    );
  },

  mounted() {
    console.log("Incidència component mounted.");
    this.actualitzarDateTime();
  },

  computed: {
    syncAlertantId() {
      this.incidencia.alertant.id = this.incidencia.alertants_id;
    },
  },

  methods: {
    //   INSERT - POST   //
    insertIncidencia() {
      let me = this;

      axios
        .post("/incidencies", me.incidencia)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
          alert(error.response.data.errorMessage);
        });
    },

    //   UPDATE - PUT   //
    updateIncidencia() {
      let me = this;

      axios
        .put("/incidencies/" + me.incidencia.id, me.incidencia)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error.response);
          console.log(error.response.data.errorMessage);
          alert(error.response.data.errorMessage);
        });
    },

    filtrarAlertantComarques() {
      this.alertantComarques = this.filtrarComarques(
        this.incidencia.alertant.municipi.comarca.provincia.id
      );

      this.alertantMunicipis = [];
      var found = false;
      var i = 0;
      var selectedProvincia = this.incidencia.alertant.municipi.comarca
        .provincia.id;

      if (selectedProvincia == 0) {
        this.alertantMunicipis = this.filtrarMunicipis(
          0,
          this.alertantComarques
        );
      }

      while (!found && i < this.provincies.length) {
        let provincia = this.provincies[i];
        if (
          provincia.id == this.incidencia.alertant.municipi.comarca.provincia.id
        ) {
          found = true;
          provincia.comarques.forEach((comarca) => {
            comarca.municipis.forEach((municipi) => {
              this.alertantMunicipis.push(municipi);
            });
          });
        }
        i++;
      }
    },

    filtrarAlertantMunicipis() {
      this.alertantMunicipis = this.filtrarMunicipis(
        this.incidencia.alertant.municipi.comarca.id,
        this.alertantComarques
      );
    },

    filtrarIncidenciaComarques() {
      this.incidenciaComarques = this.filtrarComarques(
        this.incidencia.municipi.comarca.provincia.id
      );

      this.incidenciaMunicipis = [];
      var found = false;
      var i = 0;
      var selectedProvincia = this.incidencia.municipi.comarca.provincia.id;

      if (selectedProvincia == 0) {
        this.incidenciaMunicipis = this.filtrarMunicipis(
          0,
          this.incidenciaComarques
        );
      }

      while (!found && i < this.provincies.length) {
        let provincia = this.provincies[i];
        if (provincia.id == this.incidencia.municipi.comarca.provincia.id) {
          found = true;
          provincia.comarques.forEach((comarca) => {
            comarca.municipis.forEach((municipi) => {
              this.incidenciaMunicipis.push(municipi);
            });
          });
        }
        i++;
      }
    },

    filtrarIncidenciaMunicipis() {
      this.incidenciaMunicipis = this.filtrarMunicipis(
        this.incidencia.municipi.comarca.id,
        this.incidenciaComarques
      );
    },

    filtrarComarques(idProvincia) {
      let comarques = [];

      if (idProvincia == 0) {
        this.provincies.forEach((provincia) => {
          provincia.comarques.forEach((comarca) => {
            comarques.push(comarca);
          });
        });
      } else {
        this.provincies.forEach((provincia) => {
          if (provincia.id == idProvincia) {
            provincia.comarques.forEach((comarca) => {
              comarques.push(comarca);
            });
          }
        });
      }

      return comarques;
    },

    filtrarMunicipis(idComarca, comarques) {
      let municipis = [];

      if (idComarca == 0) {
        comarques.forEach((comarca) => {
          comarca.municipis.forEach((municipi) => {
            municipis.push(municipi);
          });
        });
      } else {
        comarques.forEach((comarca) => {
          if (idComarca == comarca.id) {
            comarca.municipis.forEach((municipi) => {
              municipis.push(municipi);
            });
          }
        });
      }

      return municipis;
    },

    actualitzarDateTime() {
      var date = new Date();

      var day = date.getDate(),
        month = date.getMonth() + 1,
        year = date.getFullYear(),
        hour = date.getHours(),
        min = date.getMinutes();

      month = (month < 10 ? "0" : "") + month;
      day = (day < 10 ? "0" : "") + day;
      hour = (hour < 10 ? "0" : "") + hour;
      min = (min < 10 ? "0" : "") + min;

      var today = year + "-" + month + "-" + day,
        displayTime = hour + ":" + min;

      this.incidencia.data = today;
      this.incidencia.hora = displayTime;
    },

    initComponent() {
      let me = this;

      if (this.insert) {
        axios
          .get("/incidencies")
          .then((response) => {
            let incidencies = response.data;
            var assignarId;
            if (incidencies.length == 0) {
              assignarId = 1;
            } else {
              assignarId = incidencies[incidencies.length - 1].id + 1;
            }
            me.incidencia.id = assignarId;
            this.loading = false;
            this.loadingStatus = null;
            this.addAfectat();
          })
          .catch((error) => {
            console.log(error);
            this.loadingStatus = error;
          });
      } else {
        axios
          .get("/incidencies/" + me.idincidencia)
          .then((response) => {
            me.incidencia = response.data;
            this.loading = false;
            this.loadingStatus = null;
          })
          .catch((error) => {
            console.log(error);
            this.loadingStatus = error;
          });
      }
    },

    tabSelected(id) {
      this.currentTab = id;
      let navlinks = document.querySelectorAll(".nav-link");
      let tabContents = document.querySelectorAll(".js-tab-content");

      navlinks.forEach((navlink) => {
        if (navlink.dataset.nav == id) {
          navlink.classList.add("active");
        } else {
          navlink.classList.remove("active");
        }
      });

      tabContents.forEach((tabContent) => {
        if (tabContent.dataset.tab == id) {
          tabContent.style.display = "block";
          tabContent.classList.add("animate__fadeIn");
        } else {
          tabContent.style.display = "none";
          tabContent.classList.remove("animate__fadeIn");
        }
      });

      if (id == 1 && !this.mapMounted) {
        this.initMap();
        if (this.incidencia.adreca != "") this.geocodeAddress();
      }
    },

    fabClick() {
      //finalitzar
      if (this.currentTab == 3) {
        if (this.insert) {
          this.incidencia.alertants_id = this.incidencia.alertant.id;
          this.insertIncidencia();
        } else {
          this.updateIncidencia();
        }
      } else {
        this.tabSelected(this.currentTab + 1);
      }
    },

    addAfectat() {
      let afectat = {
        id: Math.random(),
        telefon: "",
        cip: "",
        nom: "",
        cognoms: "",
        edat: 0,
        te_cip: 0,
        sexes_id: 0,
        saveAfectat: false,
      };

      let incidencia_has_recurs = this.emptyIncidenciaHasRecurs();
      incidencia_has_recurs.afectat = afectat;
      this.incidencia.incidencia_has_recursos.push(incidencia_has_recurs);
    },

    removeAfectat(id) {
      let i = 0;
      let found = false;
      let incidencia_has_recursos = this.incidencia.incidencia_has_recursos;

      while (!found && i < incidencia_has_recursos.length) {
        let afectat = incidencia_has_recursos[i].afectat;

        if (afectat.id == id) {
          found = true;
          incidencia_has_recursos.splice(i, 1);
        }
        i++;
      }

      this.incidencia.incidencia_has_recursos = incidencia_has_recursos;
    },

    emptyIncidenciaHasRecurs() {
      return {
        afectat: {},
        incidencies_id: this.incidencia.id,
        recursos_id: 0,
        hora_activacio: "00:00",
        hora_mobilitzacio: "00:00",
        hora_assistencia: "00:00",
        hora_transport: "00:00",
        hora_arribada_hospital: "00:00",
        hora_transferencia: "00:00",
        hora_finalitzacio: "00:00",
        prioritat: 0,
        desti: "",
        recurs: {
          actiu: 0,
          codi: "",
          id: 0,
          tipus_recursos_id: 0,
          tipus_recurs: {},
          usuaris: [],
        },
      };
    },

    cercaAlertantbyTlf() {
      let me = this;

      axios
        .get("/alertant/" + me.cercaAlertant)
        .then((response) => {
          let alertant = response.data[0];
          me.incidencia.alertant.id = alertant.id;
          me.incidencia.alertant.telefon = alertant.telefon;
          me.incidencia.telefon_alertant = alertant.telefon;
          me.incidencia.alertant.nom = alertant.nom;
          me.incidencia.alertant.cognoms = alertant.cognoms;
          me.incidencia.alertant.adreca = alertant.adreca;
          me.incidencia.alertant.municipis_id = alertant.municipis_id;
          me.incidencia.alertant.tipus_alertants_id =
            alertant.tipus_alertants_id;
          me.incidencia.alertant.municipi = alertant.municipi;
          me.incidencia.alertant.tipus_alertant = alertant.tipus_alertant;
          this.loadingStatus = null;
        })
        .catch((error) => {
          me.loadingStatus = error;
        });
    },

    initMap() {
      this.map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: { lat: 41.3879, lng: 2.16992 },
      });

      this.geocoder = new google.maps.Geocoder();

      document.getElementById("submit").addEventListener("click", () => {
        this.geocodeAddress();
      });

      this.mapMounted = true;
    },

    geocodeAddress() {
      const address = document.getElementById("address").value;
      this.geocoder.geocode({ address: address }, (results, status) => {
        if (status === "OK") {
          this.map.setCenter(results[0].geometry.location);
          new google.maps.Marker({
            map: this.map,
            position: results[0].geometry.location,
          });
        } else {
          alert("No s'ha pogut localitzar l'adreça indicada (" + status + ")");
        }
      });
    },
  },
};
</script>
