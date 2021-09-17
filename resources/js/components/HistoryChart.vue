<script>
import { Bar } from "vue-chartjs";
import chartjsPluginDatalabels from "chartjs-plugin-datalabels";

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
    this.addPlugin(chartjsPluginDatalabels);
    this.renderChart(this.chartData, this.options);
  },
  watch: {
    options() {
      this.addPlugin(chartjsPluginDatalabels);
      this.renderChart(this.chartData, this.options);
    },
  },
};
</script>

