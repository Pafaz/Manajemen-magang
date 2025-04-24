import React, { useState } from "react";
import { CalendarDays, Download, Search, Eye, Printer } from "lucide-react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { CSVLink } from "react-csv";

export default function DataSuratPenerimaan() {
  const [activeTab, setActiveTab] = useState("penerimaan");
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedDate, setSelectedDate] = useState(null);

  // Sample data
  const students = [
    {
      id: 1,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 2,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 3,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 4,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 5,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 6,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 7,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 8,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
    {
      id: 9,
      nama: "Jane Cooper",
      sekolah: "SMK NEGERI 12 MALANG",
      jurusan: "Teknik Informatika",
      tanggalDaftar: "25 Januari 2025",
      tanggalDiterima: "28 Januari 2025",
      image: "/assets/img/post1.png"
    },
  ];

  const filteredStudents = students.filter(student => {
    return student.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
      student.sekolah.toLowerCase().includes(searchTerm.toLowerCase()) ||
      student.jurusan.toLowerCase().includes(searchTerm.toLowerCase());
  });

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
        : "25 March 2025"}
    </button>
  ));

  return (
    <div className="w-full p-6 bg-white-50">
      {/* Header */}
      <div className="flex justify-between items-start mb-5">
        <div>
          <h2 className="text-xl font-semibold text-[#1D2939]">Data Surat Penerimaan</h2>
          <p className="text-[#667085] text-sm mt-1">Kelola data penerimaan dengan maksimal!</p>
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
            data={students}
            filename="data_penerimaan.csv"
            headers={[
              { label: "Nama", key: "nama" },
              { label: "Sekolah", key: "sekolah" },
              { label: "Jurusan", key: "jurusan" },
              { label: "Tanggal Daftar", key: "tanggalDaftar" },
              { label: "Tanggal Diterima", key: "tanggalDiterima" },
            ]}
          >
            <button className="flex items-center gap-2 border border-gray-300 text-[#344054] px-4 py-2 rounded-lg text-sm shadow-sm hover:bg-[#0069AB] hover:text-white">
              <Download size={16} />
              Export
            </button>
          </CSVLink>
        </div>
      </div>

      <div className="border-b border-gray-200 mb-5" />

      <div className="flex flex-wrap justify-between items-center gap-3 mb-5">
        <div className="flex gap-2">
          <button
            className={`px-4 py-2 rounded-lg text-sm border ${
              activeTab === "penerimaan"
                ? "bg-[#0069AB] text-white"
                : "border-gray-300 text-[#344054]"
            }`}
            onClick={() => setActiveTab("penerimaan")}
          >
            Surat Penerimaan
          </button>
          <button
            className={`px-4 py-2 rounded-lg text-sm border ${
              activeTab === "pengantar"
                ? "bg-[#0069AB] text-white"
                : "border-gray-300 text-[#344054]"
            }`}
            onClick={() => setActiveTab("pengantar")}
          >
            Surat Pengantar
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

      {/* Table */}
      <div className="overflow-x-auto bg-white border border-gray-200 rounded-lg">
        <table className="w-full table-auto">
          <thead className="bg-gray-50 border-b border-gray-200">
            <tr className="text-left text-gray-600">
              <th className="p-4 font-medium w-12">#</th>
              <th className="p-4 font-medium">Nama</th>
              <th className="p-4 font-medium">
                <div className="flex items-center gap-1">
                  Sekolah
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </th>
              <th className="p-4 font-medium">
                <div className="flex items-center gap-1">
                  Jurusan
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </th>
              <th className="p-4 font-medium">
                <div className="flex items-center gap-1">
                  Tanggal Daftar
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </th>
              <th className="p-4 font-medium">
                <div className="flex items-center gap-1">
                  Tanggal Diterima
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </th>
              <th className="p-4 font-medium text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            {filteredStudents.map((student) => (
              <tr key={student.id} className="border-b border-gray-200 hover:bg-gray-50">
                <td className="p-4">{student.id}</td>
                <td className="p-4">
                  <div className="flex items-center gap-3">
                    <img 
                      src={student.image} 
                      alt={student.nama} 
                      className="w-8 h-8 rounded-full object-cover" 
                    />
                    <span className="font-medium">{student.nama}</span>
                  </div>
                </td>
                <td className="p-4">{student.sekolah}</td>
                <td className="p-4">{student.jurusan}</td>
                <td className="p-4">{student.tanggalDaftar}</td>
                <td className="p-4">{student.tanggalDiterima}</td>
                <td className="p-4">
                  <div className="flex justify-center gap-3">
                    <button className="text-amber-500 hover:text-amber-600">
                      <Eye size={18} />
                    </button>
                    <button className="text-blue-500 hover:text-blue-600">
                      <Printer size={18} />
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}