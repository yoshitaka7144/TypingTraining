<script>
import { Bar, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Bar,
  props: {
    chartData: null,
    options: null,
  },
  data() {
    return {};
  },
  mounted() {
    this.renderChart(this.chartData, this.options);
  },
  watch: {
    options() {
      this.renderChart(this.chartData, this.options);
    },
  },
};
</script>

