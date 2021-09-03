<script>
import { Bar, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Bar,
  mixins: [reactiveProp],
  data() {
    return {
      options: {
        maintainAspectRatio: false,
        responsive: false,
        scales: {
          xAxes: [{}],
          yAxes: [
            {
              id: "y-axis-1",
              position: "left",
              ticks: {
                max: 500,
                min: 0,
                stepSize: 25,
              },
            },
            {
              id: "y-axis-2",
              position: "right",
              ticks: {
                max: 100,
                min: 0,
                stepSize: 10,
              },
            },
          ],
        },
      },
    };
  },
  mounted() {
    this.renderChart(this.chartData, this.options);
  },
};
</script>

