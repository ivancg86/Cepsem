<template>
  <div class="col-lg-6 col-xl-4 mb-5">
    <div class="afectat-item">
      <h3 class="mb-4">AFECTAT</h3>

      <input
        type="checkbox"
        name="notecip"
        id="notecip"
        v-model="afectat.te_cip"
      />
      <label class="mb-3">Té CIP</label>

      <div class="mb-3" v-show="afectat.te_cip">
        <div class="input input--col mb-2">
          <label>CIP</label>
          <input
            type="text"
            name="cip"
            id="cip"
            placeholder="Introdueix el CIP de l'afectat..."
            v-model="afectat.cip"
          />
        </div>

        <div v-show="error" class="input-error input-error--show">
          <img
            src="/cepsem/webapp/cepsem/public/assets/icons/alert.svg"
            alt=""
            width="18px"
            height="18px"
            style="margin-bottom: auto"
          />
          <span>No s'ha trobat cap resultat</span>
        </div>

        <div style="text-align: end">
          <button
            class="button button--blue"
            style="padding-top: 8px; padding-bottom: 8px"
            @click="getAfectat"
          >
            CARREGAR DADES
          </button>
        </div>
      </div>

      <div class="input input--col mb-3">
        <label>Telèfon</label>
        <input
          type="text"
          name="telefon"
          id="telefon"
          placeholder="Introdueix el telefon de l'afectat..."
          v-model="afectat.telefon"
        />
      </div>

      <div class="input input--col mb-3">
        <label>Nom</label>
        <input
          type="text"
          name="nom"
          id="nom"
          placeholder="Introdueix el nom de l'afectat..."
          v-model="afectat.nom"
        />
      </div>

      <div class="input input--col mb-3">
        <label>Cognoms</label>
        <input
          type="text"
          name="cognoms"
          id="cognoms"
          placeholder="Introdueix els cognoms de l'afectat..."
          v-model="afectat.cognoms"
        />
      </div>

      <div class="row">
        <div class="col-lg-5">
          <div class="input input--col mb-3">
            <label>Edat</label>
            <input
              type="number"
              name="edat"
              id="edat"
              placeholder="Introdueix l'edat de l'afectat..."
              v-model="afectat.edat"
            />
          </div>
        </div>
        <div class="col-lg-7">
          <div class="input input--col mb-3">
            <label>Sexe</label>
            <b-form-select
              name="sexe"
              id="sexe"
              v-model="afectat.sexes_id"
              class="select"
              value-field="id"
              text-field="sexe"
              :options="sexes"
            ></b-form-select>
          </div>
        </div>
      </div>

      <div class="mt-4" style="text-align: center">
        <button
          class="button button-icon button--rounded button-inverted button-inverted--red removeAfectat"
          @click="removeAfectat"
        >
          Eliminar afectat
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    incidencia_has_recurs_afectat: {
      type: Object,
      required: false,
    },

    sexes: {
      type: Array,
      required: false,
    },
  },
  data() {
    return {
      afectat: {},
      error: "",
    };
  },
  created() {
    if (this.incidencia_has_recurs_afectat === undefined) {
      this.afectat = this.emptyAfectat();
    } else {
      this.afectat = this.incidencia_has_recurs_afectat;
    }
  },
  mounted() {
    console.log("Afectat amb CIP " + this.afectat.cip + " component mounted.");
  },
  destroyed() {
    console.log("Afectat amb CIP" + this.afectat.cip + " component destroyed.");
  },
  methods: {
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

    removeAfectat() {
      this.$emit("remove-afectat", this.afectat.id);
    },

    getAfectat() {
      let me = this;

      axios
        .get("/afectats/" + me.afectat.cip)
        .then((response) => {
          let afectat = response.data[0];
          me.afectat.id = afectat.id;
          me.afectat.telefon = afectat.telefon;
          me.afectat.cip = afectat.cip;
          me.afectat.nom = afectat.nom;
          me.afectat.cognoms = afectat.cognoms;
          me.afectat.edat = afectat.edat;
          me.afectat.te_cip = afectat.te_cip;
          me.afectat.sexes_id = afectat.sexes_id;
          me.afectat.sexe = afectat.sexe;
        })
        .catch((error) => {
          me.error = error;
        });
    },
  },
  computed: {},
};
</script>
