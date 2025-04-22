// components/DonutChart.jsx
import React from 'react';
import Chart from 'react-apexcharts';

export default function DonutChart() {
  const series = [361, 483]; // Data: [Free, Premium]
  const options = {
    chart: {
      type: 'donut',
    },
    labels: ['Free', 'Premium'],
    colors: ['#FBBF24', '#2563EB'], // Kuning, Biru
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    plotOptions: {
      pie: {
        donut: {
          labels: {
            show: false,
          },
        },
      },
    },
    tooltip: {
      enabled: true,
    },
  };

  const total = series.reduce((a, b) => a + b, 0);
  const percentages = series.map(value => ((value / total) * 100).toFixed(1));

  return (
    <div className="flex flex-col items-center justify-center p-4">
      <Chart options={options} series={series} type="donut" width={300} />

      <div className="flex gap-10 mt-4">
        <div className="flex items-center gap-2">
          <span className="w-3 h-3 rounded-full bg-yellow-400"></span>
          <div className="text-center">
            <p className="text-orange-500 font-semibold">Free</p>
            <p className="font-bold">{percentages[0]}%</p>
          </div>
        </div>
        <div className="flex items-center gap-2">
          <span className="w-3 h-3 rounded-full bg-blue-600"></span>
          <div className="text-center">
            <p className="text-blue-600 font-semibold">Premium</p>
            <p className="font-bold">{percentages[1]}%</p>
          </div>
        </div>
      </div>
    </div>
  );
}
