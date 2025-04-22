import React, { useState } from "react";
import Chart from "react-apexcharts";
import Title from "../Title";

const StaticAbsensiPerusahaan = () => {
  const [filter, setFilter] = useState("Cabang A");

  const dataOptions = {
    "Cabang A": {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      series: [
        { name: "Hadir", data: [3, 4, 5, 6, 7, 8, 9, 7, 6, 5, 4, 5] },
        { name: "Tidak Hadir", data: [1, 1, 2, 1, 2, 1, 2, 3, 2, 3, 2, 3] },
        { name: "Izin", data: [0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1] }, // Data Izin
      ],
    },
    "Cabang B": {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      series: [
        { name: "Hadir", data: [3, 6, 7, 6, 5, 4, 5, 6, 7, 6, 7, 8] },
        { name: "Tidak Hadir", data: [2, 3, 2, 3, 2, 1, 2, 1, 2, 1, 1, 2] },
        { name: "Izin", data: [1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 1, 1] }, // Data Izin
      ],
    },
    "Cabang C": {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      series: [
        { name: "Hadir", data: [3, 7, 8, 7, 6, 7, 8, 9, 8, 7, 6, 5] },
        { name: "Tidak Hadir", data: [1, 1, 1, 2, 2, 1, 1, 2, 2, 1, 2, 3] },
        { name: "Izin", data: [0, 0, 1, 0, 1, 1, 0, 0, 1, 1, 0, 0] }, // Data Izin
      ],
    },
    "Cabang D": {
      categories: [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
      ],
      series: [
        { name: "Hadir", data: [4, 3, 4, 5, 6, 5, 4, 4, 5, 6, 7, 6] },
        { name: "Tidak Hadir", data: [3, 2, 2, 1, 1, 2, 3, 2, 3, 2, 1, 1] },
        { name: "Izin", data: [1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 1] }, // Data Izin
      ],
    },
  };

  const options = {
    chart: {
      type: "area",
      toolbar: { show: false },
    },
    colors: ["#27CFA7", "#1E40AF", "#F1C40F"], // Warna untuk Hadir, Tidak Hadir, Izin
    stroke: { curve: "smooth", width: 2 },
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.4,
        opacityTo: 0,
        stops: [0, 100],
      },
    },
    dataLabels: { enabled: false },
    xaxis: {
      categories: dataOptions[filter].categories,
    },
    yaxis: {
      min: 0,
      max: 10,
    },
    legend: {
      position: "top",
      horizontalAlign: "left",
      floating: true,
      offsetX: 570,
      offsetY: -40,
    },
  };

  return (
    <>
      <div className="flex flex-wrap justify-between items-center mb-3">
  <Title className="ml-5">Statistik Absensi</Title>
  <select
    className="border border-gray-300/[0.5] rounded-lg px-2 py-0.5 text-sm text-center text-gray-500 z-5 focus:outline-none mt-2 sm:mt-0"
    value={filter}
    onChange={(e) => setFilter(e.target.value)}
  >
    {Object.keys(dataOptions).map((key) => (
      <option key={key} value={key}>
        {key}
      </option>
    ))}
  </select>
</div>

      <Chart
        options={options}
        series={dataOptions[filter].series}
        type="area"
        height={400}
      />
    </>
  );
};

export default StaticAbsensiPerusahaan;
