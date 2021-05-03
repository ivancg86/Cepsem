<template>
  <div class="recurs-item mb-4">
    <h3 class="section-title mr-2 mb-4">
      <img src="/cepsem/webapp/cepsem/public/assets/icons/person.svg" alt="" />

      <div class="ml-2">
        <span v-if="incidencia_has_recurs.afectat.nom"
          >{{ incidencia_has_recurs.afectat.nom + " -" }}&nbsp;</span
        >
        <span v-if="incidencia_has_recurs.afectat.sexes_id == 1"
          >Home,&nbsp;</span
        >
        <span v-else>Dona, </span>
        <span v-if="incidencia_has_recurs.afectat.edat">{{
          " " + incidencia_has_recurs.afectat.edat + " anys"
        }}</span>
      </div>
    </h3>

    <div class="container-fluid">
      <h5><b>ASSIGNACIÓ DE RECURS MÒBIL</b></h5>

      <div class="row mt-4">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-lg-6">
              <div class="input input--col mb-4">
                <label :for="'tipusrecurs' + incidencia_has_recurs.id">Tipus recurs Mòbil</label>
                <b-form-select
                  name="tipusrecurs"
                  id="tipusrecurs"
                  v-model="incidencia_has_recurs.recurs.tipus_recursos_id"
                  class="select"
                  value-field="id"
                  text-field="tipus"
                  :options="tipusrecursos"
                ></b-form-select>
              </div>
            </div>

            <div class="col-lg-6 m-auto">
              <button
                class="button button-rounded button--blue"
                @click="getAvailableRecurs"
              >
                Assignar automàticament
              </button>
            </div>

            <div class="col-lg-4">
              <div class="input input--col mb-4">
                <label>Prioritat</label>
                <b-form-select
                  name="prioritat"
                  id="prioritat"
                  class="select"
                  v-model="incidencia_has_recurs.prioritat"
                  :options="prioritats"
                ></b-form-select>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="input input--col mb-2">
                <label>Hora d'activació</label>
                <div v-if="insert">
                  <input
                    type="time"
                    name="horaActi"
                    id="horaActi"
                    v-model="hora"
                  />
                </div>
                <div v-else>
                  <input
                    type="time"
                    name="horaActi"
                    id="horaActi"
                    v-model="incidencia_has_recurs.hora_activacio"
                  />
                </div>
              </div>
            </div>

            <div class="col-lg-12 mb-3">
              <input
                type="checkbox"
                name="trasllat"
                id="trasllat"
                v-model="trasllat"
              />
              <label>Trasllat Hospitalari</label>
            </div>

            <div class="row" v-if="trasllat">
              <div class="col-lg-12">
                <div class="input input--col mb-4">
                  <label>Destí Hospitalari</label>
                  <input
                    type="text"
                    name="desti"
                    id="desti"
                    placeholder="Introdueix lloc de destí..."
                    v-model="incidencia_has_recurs.desti"
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-2">
                  <label>Hora de Transport</label>
                  <input
                    type="time"
                    name="horatransport"
                    id="horatransport"
                    placeholder="Introdueix l'hora de transport..."
                    v-model="incidencia_has_recurs.hora_transport"
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-2">
                  <label>Hora de Transferència</label>
                  <input
                    type="time"
                    name="horatransferencia"
                    id="horatransferencia"
                    placeholder="Introdueix l'hora de transferencia..."
                    v-model="incidencia_has_recurs.hora_transferencia"
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-2">
                  <label>Hora de Finalització</label>
                  <input
                    type="time"
                    name="horafinal"
                    id="horafinal"
                    placeholder="Introdueix l'hora de finalització..."
                    v-model="incidencia_has_recurs.hora_finalitzacio"
                  />
                </div>
              </div>

              <div class="col-lg-6">
                <div class="input input--col mb-2">
                  <label>Hora d'arribada a l'hospital</label>
                  <input
                    type="time"
                    name="horahospital"
                    id="horahospital"
                    placeholder="Introdueix l'hora d'arribada a l'hospital..."
                    v-model="incidencia_has_recurs.hora_arribada_hospital"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4" v-if="incidencia_has_recurs.recurs.id > 0">
          <div class="row"></div>
          <div class="recurs-info">
            <div class="recurs-info__head">
              <img
                v-if="incidencia_has_recurs.recurs.tipus_recursos_id == 4"
                src="/cepsem/webapp/cepsem/public/assets/icons/helicopter.svg"
                alt=""
              />
              <img
                v-else
                src="/cepsem/webapp/cepsem/public/assets/icons/ambulance.svg"
                alt=""
              />
              <h4 class="ml-2">
                {{ incidencia_has_recurs.recurs.tipus_recurs.tipus }}
              </h4>
            </div>
            <p>ID: {{ incidencia_has_recurs.recurs.id }}</p>
            <p>Codi: {{ incidencia_has_recurs.recurs.codi }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    incidencia_has_recurs: {
      type: Object,
      required: false,
    },
    tipusrecursos: {
      type: Array,
      required: false,
    },
    sexes: {
      type: Array,
      required: false,
    },
    usuarilogin: {
      type: Object,
      required: false,
    },
    usuarirecurs: {
      type: Object,
      required: false,
    },
    insert: {
      type: Boolean,
      required: true,
    },
  },
  data() {
    return {
      trasllat: false,
      prioritats: [1, 2, 3, 4, 5],
      hora: this.checkUpdate(),
      afectat: {},
    };
  },
  created() {
    this.recurs = this.incidencia_has_recurs;
    if (this.incidencia_has_recurs.afectat === undefined) {
      this.incidencia_has_recurs.afectat = this.emptyAfectat();
    }
  },
  mounted() {},
  methods: {
    checkUpdate() {
      if (this.insert) {
        this.getTime();
      }
    },
    getTime() {
      var today = new Date();

      var hour = today.getHours(),
        min = today.getMinutes();

      hour = (hour < 10 ? "0" : "") + hour;
      min = (min < 10 ? "0" : "") + min;

      var time = hour + ":" + min;

      setTimeout(this.getTime, 5000);
      this.hora = time;
    },

    emptyAfectat() {
      return {
        id: 0,
        telefon: "",
        cip: "",
        nom: "",
        cognoms: "",
        edat: 0,
        te_cip: false,
        sexes_id: 0,
        sexe: {
          id: 0,
          sexe: "",
        },
        saveAfectat: false,
      };
    },

    getAvailableRecurs() {
      if (
        this.incidencia_has_recurs.recurs.tipus_recursos_id >= 1 &&
        this.incidencia_has_recurs.recurs.tipus_recursos_id <= 4
      ) {
        let me = this;

        if (this.incidencia_has_recurs.recurs.id > 0) {
          this.setRecursActiu(this.incidencia_has_recurs.recurs.id, 0);
          console.log(
            "Recurs amb id " +
              this.incidencia_has_recurs.recurs.id +
              " en espera."
          );
        }

        axios
          .get(
            "/recursos/notactiu/" +
              this.incidencia_has_recurs.recurs.tipus_recursos_id
          )
          .then((response) => {
            var recursosDisponibles = response.data;

            if (recursosDisponibles.length > 0) {
              me.incidencia_has_recurs.recurs = recursosDisponibles[0];
              me.incidencia_has_recurs.recursos_id = recursosDisponibles[0].id;
              this.setRecursActiu(recursosDisponibles[0].id, 1);
            } else {
              alert("No hi ha recursos d'aquest tipus disponible");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        console.log("Selecciona un tipus de recurs vàlid");
      }
    },

    setRecursActiu(id, val) {
      axios
        .get("/recursos/" + id + "/actiu/" + val)
        .then((response) => {
          console.log("Recurs amb id " + id + " en marxa.");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  computed: {},
};
</script>
