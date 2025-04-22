import React, { useState } from "react";
import Chart from "react-apexcharts";

// Komponen Title opsional, bisa diganti h2 biasa
const Title = ({ children, className }) => (
  <h2 className={`text-lg font-semibold text-gray-900 ${className || ""}`}>{children}</h2>
);

const PesertaMagangChart = () => {
  const [filter, setFilter] = useState("Cabang A");

  const chartData = {
    "Cabang A": {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      series: [
        { name: "Aktif", data: [45, 50, 42, 48, 38, 45, 44, 47, 50, 43, 49, 35] },
        { name: "Alumni", data: [25, 30, 18, 40, 30, 25, 36, 29, 28, 27, 38, 30] },
      ],
    },
    "Cabang B": {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      series: [
        { name: "Aktif", data: [30, 35, 28, 32, 29, 34, 33, 31, 36, 38, 37, 35] },
        { name: "Alumni", data: [15, 18, 14, 17, 16, 18, 20, 19, 21, 22, 20, 19] },
      ],
    },
    "Cabang C": {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      series: [
        { name: "Aktif", data: [20, 25, 22, 24, 23, 26, 25, 27, 29, 28, 30, 27] },
        { name: "Alumni", data: [10, 12, 11, 13, 12, 14, 13, 15, 14, 13, 15, 14] },
      ],
    },
  };

  const colors = ["#1E40AF", "#BFDBFE"];
  const selectedData = chartData[filter] || { categories: [], series: [] };

  const options = {
    chart: {
      type: "bar",
      stacked: true,
      toolbar: { show: false },
    },
    colors: colors,
    xaxis: {
      categories: selectedData.categories,
      labels: {
        style: {
          fontSize: "12px",
          colors: "#6B7280", // text-gray-500
        },
      },
    },
    legend: {
      position: "top",
      horizontalAlign: "right",
      labels: {
        colors: "#374151", // text-gray-700
      },
    },
    dataLabels: {
      enabled: false,
    },
    plotOptions: {
      bar: {
        borderRadius: 6,
        columnWidth: "45%",
      },
    },
    tooltip: {
      shared: true,
      intersect: false,
    },
    grid: {
      strokeDashArray: 4,
      borderColor: "#E5E7EB", // gray-200
    },
  };

  return (
  <div className="bg-white p-6 rounded-xl shadow-sm">
    <div className="flex justify-between items-center mb-4">
      <Title>Statistik Jurnal</Title>
      <div className="flex items-center gap-4">
        <select
          className="border border-gray-300/[0.5] rounded-lg px-2 py-1 text-sm text-center text-gray-500 focus:outline-none"
          value={filter}
          onChange={(e) => setFilter(e.target.value)}
        >
          {Object.keys(chartData).map((cabang) => (
            <option key={cabang} value={cabang}>
              {cabang}
            </option>
          ))}
        </select>

        {/* Dynamic Legend */}
        <div className="flex items-center gap-4 text-sm text-gray-700">
          {selectedData.series.map((item, index) => (
            <div key={item.name} className="flex items-center gap-1">
              <div
                className="w-2 h-2 rounded-full"
                style={{ backgroundColor: colors[index % colors.length] }}
              />
              {item.name}
            </div>
          ))}
        </div>
      </div>
    </div>

    <Chart
      options={options}
      series={selectedData.series}
      type="bar"
      height={450}
    />
  </div>
);

};

export default PesertaMagangChart;
