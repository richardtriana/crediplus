<template>
  <div class="modal fade" id="cuotasModal" tabindex="-1" role="dialog" aria-labelledby="cuotasModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cuotasModalLabel">Listado de Cuotas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="page-header d-flex justify-content-between p-4 border my-2">
            <div class="form-row w-100">
              <div class="form-group col-2">
                <label for="amount">Monto a pagar: <b>{{ amount_value | currency }}</b></label>
              </div>
              <div class="form-group col-4">
                <input type="number" step="any" class="form-control" id="amount" placeholder="$" v-model="amount_value"
                  :min="min_amount" />
                <small id="addAmountHelpBlock" class="form-text text-muted">
                  Monto mínimo
                  {{ 0 | currency }}
                </small>
              </div>
              <div class="col-3 form-group">
                <input type="number" step="any" class="form-control" id="new_interest" v-model="new_interest" min="0">
              </div>
              <div class="form-group col-3">
                <button class="btn btn-primary my-auto" @click="payCredit()" v-if="amount_value > 0">
                  Abonar <b>{{ amount_value | currency }}</b>
                </button>
                <button v-else class="btn btn-secondary my-auto" disabled>
                  <i class="bi bi-currency-dollar"></i> Abonar a crédito
                </button>
              </div>

              <div class="form-group col-3">
                <h5>Saldo pendiente: <b>{{ credit_to_pay | currency }}</b> </h5>
              </div>
              <div class="form-group col-12 text-center">
                <button class="btn btn-danger w-50 font-weight-bold" @click="printTable()">
                  <i class="bi bi-file-pdf"></i> Tabla de amortización
                </button>
              </div>
            </div>
          </div>
          <installment ref="Installment" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Installment from "./Installment.vue";
export default {
  components: { Installment },
  data() {
    return {
      id_credit: 0,
      allow_payment: 0,
      amount_value: 0,
      allow_payment: 1,
      min_amount: 0,
      credit_to_pay: 0,
      new_interest: 0
    };
  },
  methods: {
    listCreditInstallments: function (credit_id, allow_payment, credit) {
      this.id_credit = credit_id;
      this.allow_payment = allow_payment;
      this.min_amount = credit.installment_value;
      this.credit_to_pay = credit.credit_to_pay;
      this.new_interest = credit.interest;
      this.$refs.Installment.listCreditInstallments(credit_id, allow_payment);
    },

    payCredit() {
      let pending_installment = this.$refs.Installment.listInstallments.filter((x) => x.paid_capital > 0 && x.status === 0);

      if (pending_installment.length) {
        return  Swal.fire({
          icon: "error",
          title: "Oops...",
          text: `No se puede abonar a capital hasta que la cuota este paga completamente`,
        });
      }

      if (this.amount_value > 0) {
        this.$refs.Installment.payCredit(this.amount_value, this.new_interest);
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: `El valor debe ser mayor a ${this.min_amount}`,
        });
      }
    },

    printTable() {
      axios
        .get(
          `api/credits/amortization-table?credit_id=${this.id_credit}`,
          this.$root.config
        )
        .then((response) => {
          const pdf = response.data.pdf;
          var a = document.createElement("a");
          a.href = "data:application/pdf;base64," + pdf;
          a.download = `credit_${this.id_credit}-${Date.now()}.pdf`;
          a.target = "_blank";
          a.click();
        });
    },
  },
};
</script>
