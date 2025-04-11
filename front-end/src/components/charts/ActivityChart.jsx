import React, { useEffect, useRef } from "react";
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";

const ActivityChart = () => {
  const chartRef = useRef(null);

  useEffect(() => {
    if (chartRef.current) {
      const ctx = chartRef.current.getContext("2d");

      if (chartRef.current.chart) {
        chartRef.current.chart.destroy();
      }

      chartRef.current.chart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: ["Complete", "Waiting List", "Revision"],
          datasets: [
            {
              data: [65.2, 25.0, 9.8],
              backgroundColor: ["#007bff", "#00C897", "#FFA500"],
              hoverOffset: 4,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            datalabels: {
              color: "#fff",
              formatter: (value) => `${value}%`,
              font: {
                weight: 'bold',
                size: 12,
              },
            },
          },
          cutout: "70%",
        },
        plugins: [ChartDataLabels],
      });
    }
  }, []);

  return (
    <div className="py-3">
      <div className="flex justify-center py-5">
        <div className="relative w-[200px] h-[200px]">
          <canvas ref={chartRef} className="w-full h-full"></canvas>
        </div>
      </div>

      <div className="flex gap-5 mt-4 px-5 justify-center">
        <div className="flex flex-col items-center">
          <div className="w-3 h-3 bg-[#007bff] rounded-full"></div>
          <div className="text-xs mt-2 text-[#007bff]">Complete</div>
          <h1 className="font-semibold text-xs mt-3">65.2%</h1>
        </div>
        <div className="flex flex-col items-center">
          <div className="w-3 h-3 bg-[#00C897] rounded-full"></div>
          <div className="text-xs mt-2 text-[#00C897]">Waiting List</div>
          <h1 className="font-semibold text-xs mt-3">25.0%</h1>
        </div>
        <div className="flex flex-col items-center">
          <div className="w-3 h-3 bg-[#FFA500] rounded-full"></div>
          <div className="text-xs mt-2 text-[#FFA500]">Revision</div>
          <h1 className="font-semibold text-xs mt-3">9.8%</h1>
        </div>
      </div>
    </div>
  );
};

export default ActivityChart;
