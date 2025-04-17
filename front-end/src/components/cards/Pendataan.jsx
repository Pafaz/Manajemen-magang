import React, { useState } from "react";
import { CalendarDays, Download, Search } from "lucide-react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { CSVLink } from "react-csv";
import Jurnal from "./Jurnal";
import Absensi from "./Absensi";

export default function Pendataan() {
  const [activeTab, setActiveTab] = useState("Jurnal");
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedDate, setSelectedDate] = useState(null);

  const dataJurnal = [
    {
      id: 1,
      nama: "Arya Pratama",
      sekolah: "SMK NEGERI 5 SURABAYA",
      tanggal: "2025-04-15",
      deskripsi: "Mengembangkan halaman landing page menggunakan HTML, Tailwind CSS, dan JavaScript.",
      status: "Mengisi",
      image: "/assets/img/post1.png",
      buktiJurnal: "/berkas/izin/izin.jpg"
    },
    {
      id: 2,
      nama: "Dewi Lestari",
      sekolah: "SMK PGRI 2 JEMBER",
      tanggal: "2025-04-14",
      deskripsi: "Membuat konten sosial media untuk promosi produk menggunakan Canva dan CapCut.",
      status: "Mengisi",
      image: "/assets/img/post2.png",
      buktiJurnal: "/berkas/izin/izin2.jpg"
    },
    {
      id: 3,
      nama: "Budi Santoso",
      sekolah: "SMK NEGERI 1 MALANG",
      tanggal: "2025-04-13",
      deskripsi: "-",
      status: "Tidak Mengisi",
      image: "/assets/img/post1.png",
      buktiJurnal: ""
    },
    {
      id: 4,
      nama: "Siti Nurhaliza",
      sekolah: "SMK MUHAMMADIYAH 1 KEDIRI",
      tanggal: "2025-04-12",
      deskripsi: "-",
      status: "Tidak Mengisi",
      image: "/assets/img/post2.png",
      buktiJurnal: ""
    },
    {
      id: 5,
      nama: "Rizky Aditya",
      sekolah: "SMK NEGERI 3 PASURUAN",
      tanggal: "2025-04-11",
      deskripsi: "-",
      status: "Tidak Mengisi",
      image: "/assets/img/post1.png",
      buktiJurnal: ""
    },
    {
      id: 6,
      nama: "Intan Permata",
      sekolah: "SMK YPM 4 TAMAN",
      tanggal: "2025-04-10",
      deskripsi: "Membuat wireframe website company profile menggunakan Figma.",
      status: "Mengisi",
      image: "/assets/img/post2.png",
      buktiJurnal: "/berkas/izin/izin6.jpg"
    },
    {
      id: 7,
      nama: "Gilang Maulana",
      sekolah: "SMK NEGERI 2 TULUNGAGUNG",
      tanggal: "2025-04-09",
      deskripsi: "-",
      status: "Tidak Mengisi",
      image: "/assets/img/post1.png",
      buktiJurnal: ""
    },
    {
      id: 8,
      nama: "Nadya Rahma",
      sekolah: "SMK PGRI 1 MOJOKERTO",
      tanggal: "2025-04-08",
      deskripsi: "-",
      status: "Tidak Mengisi",
      image: "/assets/img/post2.png",
      buktiJurnal: ""
    },
    {
      id: 9,
      nama: "Fajar Nugroho",
      sekolah: "SMK NEGERI 2 BLITAR",
      tanggal: "2025-04-07",
      deskripsi: "Membuat halaman profil pengguna dan fitur edit data menggunakan React dan Laravel.",
      status: "Mengisi",
      image: "/assets/img/post1.png",
      buktiJurnal: "/berkas/izin/izin1.jpg"
    },
    {
      id: 10,
      nama: "Putri Ayu",
      sekolah: "SMK NEGERI 1 SIDOARJO",
      tanggal: "2025-04-06",
      deskripsi: "Mendesain logo brand lokal untuk UMKM menggunakan Adobe Photoshop.",
      status: "Mengisi",
      image: "/assets/img/post2.png",
      buktiJurnal: "/berkas/izin/izin2.jpg"
    }
  ];
  const dataAbsensi = [
    {
      id: 1,
      nama: "Dewi Anggraini",
      jamMasuk: "08:05",
      istirahat: "12:00",
      kembali: "13:00",
      pulang: "15:00",
      status: "Hadir",
      metode: "Tab",
      image: "/assets/img/post2.png",
    },
    {
      id: 2,
      nama: "Rizki Ananda",
      jamMasuk: "08:00",
      istirahat: "12:00",
      kembali: "13:00",
      pulang: "15:00",
      status: "Terlambat",
      metode: "Online",
      image: "/assets/img/post2.png",
    },
    {
      id: 3,
      nama: "Fajar Nugroho",
      jamMasuk: "08:10",
      istirahat: "12:15",
      kembali: "13:15",
      pulang: "15:10",
      status: "Hadir",
      metode: "Tab",
      image: "/assets/img/post1.png",
    },
    {
      id: 4,
      nama: "Siti Nurhaliza",
      jamMasuk: "-",
      istirahat: "-",
      kembali: "-",
      pulang: "-",
      status: "Alpha",
      metode: "-",
      image: "/assets/img/post2.png",
    },
    {
      id: 5,
      nama: "Rizky Aditya",
      jamMasuk: "08:00",
      istirahat: "12:00",
      kembali: "13:00",
      pulang: "15:00",
      status: "Terlambat",
      metode: "Tab",
      image: "/assets/img/post1.png",
    },
    {
      id: 6,
      nama: "Intan Permata",
      jamMasuk: "08:05",
      istirahat: "12:00",
      kembali: "13:00",
      pulang: "15:05",
      status: "Hadir",
      metode: "Online",
      image: "/assets/img/post1.png",
    },
    {
      id: 7,
      nama: "Gilang Maulana",
      jamMasuk: "08:15",
      istirahat: "12:15",
      kembali: "13:15",
      pulang: "15:00",
      status: "Hadir",
      metode: "Tab",
      image: "/assets/img/post2.png",
    },
    {
      id: 8,
      nama: "Nadya Rahma",
      jamMasuk: "-",
      istirahat: "-",
      kembali: "-",
      pulang: "-",
      status: "Alpha",
      metode: "-",
      image: "/assets/img/post2.png",
    },
    {
      id: 9,
      nama: "Budi Santoso",
      jamMasuk: "08:10",
      istirahat: "12:15",
      kembali: "13:15",
      pulang: "15:10",
      status: "Terlambat",
      metode: "Tab",
      image: "/assets/img/post1.png",
    },
    {
      id: 10,
      nama: "Arya Pratama",
      jamMasuk: "08:00",
      istirahat: "12:00",
      kembali: "13:00",
      pulang: "15:00",
      status: "Hadir",
      metode: "Online",
      image: "/assets/img/post1.png",
    },
  ];
  
  

  const CustomButton = React.forwardRef(({ value, onClick }, ref) => (
    <button
      className="flex items-center gap-2 bg-white border-gray-200 text-[#344054] py-2 px-4 rounded-md shadow border border-[#667797] hover:bg-[#0069AB] hover:text-white text-sm"
      onClick={onClick}
      ref={ref}
      type="button"
    >
      <CalendarDays size={16} />
      {value
        ? new Date(value).toLocaleDateString("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
          })
        : "Pilih Tanggal"}
    </button>
  ));

  return (
    <div className="w-full">
      <div className="bg-white rounded-xl border border-gray-200 shadow-md overflow-hidden">
        <div className="p-6">
          {/* Header */}
          <div className="flex justify-between items-start">
            <div>
              <h2 className="text-xl font-semibold text-[#1D2939]">Pendataan Admin</h2>
              <p className="text-[#667085] text-sm mt-1">Kelola pendataan dengan lebih fleksibel!</p>
            </div>

            <div className="flex items-center gap-3">
              <DatePicker
                selected={selectedDate}
                onChange={(date) => setSelectedDate(date)}
                customInput={<CustomButton />}
                dateFormat="dd MMMM yyyy"
                showPopperArrow={false}
              />
              <CSVLink
                data={activeTab === "Jurnal" ? dataJurnal : dataAbsensi}
                filename={`data_${activeTab}.csv`}
                headers={
                  activeTab === "Jurnal"
                    ? [
                        { label: "Nama", key: "nama" },
                        { label: "Sekolah", key: "sekolah" },
                        { label: "Tanggal", key: "tanggal" },
                        { label: "Deskripsi", key: "deskripsi" },
                        { label: "Status Jurnal", key: "status" },
                      ]
                    : [
                        { label: "Nama", key: "nama" },
                        { label: "Jam Masuk", key: "jamMasuk" },
                        { label: "Istirahat", key: "istirahat" },
                        { label: "Kembali", key: "kembali" },
                        { label: "Pulang", key: "pulang" },
                        { label: "Metode", key: "metode" },
                        { label: "Status", key: "status" },
                      ]
                }
              >
                <button className="flex items-center gap-2 border border-gray-300 text-[#344054] px-4 py-2 rounded-lg text-sm shadow-sm hover:bg-[#0069AB] hover:text-white">
                  <Download size={16} />
                  Export
                </button>
              </CSVLink>
            </div>
          </div>

          <div className="border-b border-gray-200 my-5" />

          <div className="flex flex-wrap justify-between items-center gap-3">
            <div className="flex gap-2">
              <button
                className={`px-4 py-2 rounded-lg text-sm border ${
                  activeTab === "Jurnal"
                    ? "bg-[#0069AB] text-white"
                    : "border-gray-300 text-[#344054]"
                }`}
                onClick={() => setActiveTab("Jurnal")}
              >
                Jurnal
              </button>
              <button
                className={`px-4 py-2 rounded-lg text-sm border ${
                  activeTab === "Absensi"
                    ? "bg-[#0069AB] text-white"
                    : "border-gray-300 text-[#344054]"
                }`}
                onClick={() => setActiveTab("Absensi")}
              >
                Absensi
              </button>
            </div>

            <div className="relative">
              <input
                type="text"
                placeholder="Search..."
                className="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <span className="absolute left-3 top-2.5 text-gray-400">
                <Search size={16} />
              </span>
            </div>
          </div>
        </div>

        {/* Table */}
        {activeTab === "Jurnal" ? (
          <Jurnal data={dataJurnal} searchTerm={searchTerm} selectedDate={selectedDate} />
        ) : (
          <Absensi data={dataAbsensi} searchTerm={searchTerm} selectedDate={selectedDate} />
        )}
      </div>
    </div>
  );
}
