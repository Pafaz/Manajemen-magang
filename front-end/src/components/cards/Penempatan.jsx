import React, { useState } from "react";
import { CalendarDays, Download, Search, X } from "lucide-react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { CSVLink } from "react-csv";

// Modal Components
const TempatkanModal = ({ isOpen, onClose, onSimpan, data }) => {
  const [nama, setNama] = useState(data?.nama || "");
  const [divisi, setDivisi] = useState("");

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 flex items-center justify-center z-50">
      {/* Overlay */}
      <div className="fixed inset-0 bg-black/40 bg-opacity-50" onClick={onClose}></div>
      
      {/* Modal */}
      <div className="bg-white rounded-lg shadow-lg w-full max-w-md z-10 relative">
        {/* Header */}
        <div className="flex justify-between items-center p-4 border-b border-gray-100">
          <h3 className="text-lg font-semibold">Tempatkan Divisi</h3>
          <button onClick={onClose} className="text-gray-500 hover:text-gray-700">
            <X size={20} />
          </button>
        </div>
        
        {/* Body */}
        <div className="p-6">
          <div className="mb-4">
            <label className="block text-sm font-medium mb-2">Masukkan Nama</label>
            <input
              type="text"
              className="w-full px-3 py-2 border border-gray-300 rounded-md"
              placeholder="Gojo satoru"
              value={nama}
              onChange={(e) => setNama(e.target.value)}
            />
          </div>
          
          <div className="mb-6">
            <label className="block text-sm font-medium mb-2">Masukkan Divisi</label>
            <div className="relative">
              <select
                className="w-full px-3 py-2 border border-gray-300 rounded-md appearance-none bg-white"
                value={divisi}
                onChange={(e) => setDivisi(e.target.value)}
              >
                <option value="" disabled>Pilih Divisi</option>
                <option value="web">Web Development</option>
                <option value="mobile">Mobile Development</option>
                <option value="ui">UI/UX Designer</option>
                <option value="data">Data Analyst</option>
              </select>
              <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                <svg className="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
          
          {/* Actions */}
          <div className="flex justify-end gap-3">
            <button
              onClick={onClose}
              className="px-5 py-2 bg-red-400 text-white rounded-full hover:bg-red-500"
            >
              Batal
            </button>
            <button
              onClick={() => {
                onSimpan({ nama, divisi });
                onClose();
              }}
              className="px-5 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700"
            >
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

const GantiModal = ({ isOpen, onClose, onSimpan, data }) => {
  const [nama, setNama] = useState(data?.nama || "");
  const [divisi, setDivisi] = useState("");

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 flex items-center justify-center z-50">
      {/* Overlay */}
      <div className="fixed inset-0 bg-black/40 bg-opacity-50" onClick={onClose}></div>
      
      {/* Modal */}
      <div className="bg-white rounded-lg shadow-lg w-full max-w-md z-10 relative">
        {/* Header */}
        <div className="flex justify-between items-center p-4 border-b border-gray-100">
          <h3 className="text-lg font-semibold">Ganti Divisi</h3>
          <button onClick={onClose} className="text-gray-500 hover:text-gray-700">
            <X size={20} />
          </button>
        </div>
        
        {/* Body */}
        <div className="p-6">
          <div className="mb-4">
            <label className="block text-sm font-medium mb-2">Masukkan Nama</label>
            <input
              type="text"
              className="w-full px-3 py-2 border border-gray-300 rounded-md"
              placeholder="Gojo satoru"
              value={nama}
              onChange={(e) => setNama(e.target.value)}
            />
          </div>
          
          <div className="mb-6">
            <label className="block text-sm font-medium mb-2">Masukkan Divisi</label>
            <div className="relative">
              <select
                className="w-full px-3 py-2 border border-gray-300 rounded-md appearance-none bg-white"
                value={divisi}
                onChange={(e) => setDivisi(e.target.value)}
              >
                <option value="" disabled>Pilih Divisi</option>
                <option value="web">Web Development</option>
                <option value="mobile">Mobile Development</option>
                <option value="ui">UI/UX Designer</option>
                <option value="data">Data Analyst</option>
              </select>
              <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                <svg className="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
          
          {/* Actions */}
          <div className="flex justify-end gap-3">
            <button
              onClick={onClose}
              className="px-5 py-2 bg-red-400 text-white rounded-full hover:bg-red-500"
            >
              Batal
            </button>
            <button
              onClick={() => {
                onSimpan({ nama, divisi });
                onClose();
              }}
              className="px-5 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700"
            >
              Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

// Main Surat Component
export default function Surat() {
  const [activeTab, setActiveTab] = useState("DataPenerimaan");
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedDate, setSelectedDate] = useState(null);
  
  // Add modal state
  const [isTempatkanModalOpen, setIsTempatkanModalOpen] = useState(false);
  const [isGantiModalOpen, setIsGantiModalOpen] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);

  const dataPenerimaan = [
    {
      id: 1,
      nama: "Arya Pratama",
      sekolah: "SMK NEGERI 5 SURABAYA",
      jurusan: "Teknik Informatika",
      tanggalMulai: "2024-01-10",
      tanggalSelesai: "2024-06-10",
      email: "arya.pratama@example.com",
      image: "/assets/img/post1.png",
    },
    {
      id: 2,
      nama: "Dewi Lestari",
      sekolah: "SMK PGRI 2 JEMBER",
      jurusan: "Teknik Informatika",
      tanggalMulai: "2024-01-12",
      tanggalSelesai: "2024-06-12",
      email: "dewi.lestari@example.com",
      image: "/assets/img/post2.png",
    },
    {
      id: 3,
      nama: "Rizki Ananda",
      sekolah: "SMK NEGERI 1 MALANG",
      jurusan: "Teknik Elektro",
      tanggalMulai: "2024-02-01",
      tanggalSelesai: "2024-07-01",
      email: "rizki.ananda@example.com",
      image: "/assets/img/post1.png",
    },
    {
      id: 4,
      nama: "Nina Wulandari",
      sekolah: "SMK SRIWIJAYA",
      jurusan: "Manajemen Bisnis",
      tanggalMulai: "2024-03-15",
      tanggalSelesai: "2024-08-15",
      email: "nina.wulandari@example.com",
      image: "/assets/img/post2.png",
    },
    {
      id: 5,
      nama: "Fajar Hidayat",
      sekolah: "SMK PGRI 1 MALANG",
      jurusan: "Akuntansi",
      tanggalMulai: "2024-04-01",
      tanggalSelesai: "2024-09-01",
      email: "fajar.hidayat@example.com",
      image: "/assets/img/post1.png",
    },
  ];

  const CustomButton = React.forwardRef(({ value, onClick }, ref) => (
    <button
      className="flex items-center gap-2 bg-white border-gray-200 text-[#344054] py-2 px-4 rounded-md border border-[#667797] hover:bg-[#0069AB] hover:text-white text-xs"
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
        : "Pilih tanggal"}
    </button>
  ));

  const filteredData = dataPenerimaan.filter((item) => {
    const isMatchSearch =
      item.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.sekolah.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.email.toLowerCase().includes(searchTerm.toLowerCase());

    const isMatchDate = selectedDate
      ? new Date(item.tanggalMulai).toLocaleDateString() ===
        selectedDate.toLocaleDateString()
      : true;

    return isMatchSearch && isMatchDate;
  });

  // Updated handlers to open modals
  const handlePlace = (item) => {
    setSelectedItem(item);
    setIsTempatkanModalOpen(true);
  };

  const handleChange = (item) => {
    setSelectedItem(item);
    setIsGantiModalOpen(true);
  };

  // Handle modal form submissions
  const handleSimpanTempatkan = (formData) => {
    console.log("Tempatkan data:", formData);
    // Add logic to update data
  };

  const handleSimpanGanti = (formData) => {
    console.log("Ganti data:", formData);
    // Add logic to update data
  };

  return (
    <div className="w-full">
      <div className="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div className="p-6">
          <div className="flex justify-between items-start">
            <div>
              <h2 className="text-lg font-semibold text-[#1D2939]">Pendataan Admin</h2>
              <p className="text-[#667085] text-xs mt-1">Kelola pendataan dengan lebih fleksibel!</p>
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
                data={dataPenerimaan}
                filename={`data_penerimaan.csv`}
                headers={[
                  { label: "Nama", key: "nama" },
                  { label: "Sekolah", key: "sekolah" },
                  { label: "Jurusan", key: "jurusan" },
                  { label: "Tanggal Mulai", key: "tanggalMulai" },
                  { label: "Tanggal Selesai", key: "tanggalSelesai" },
                  { label: "Email", key: "email" },
                ]}
              >
                <button className="flex items-center gap-2 border border-gray-300 text-[#344054] px-4 py-2 rounded-lg text-xs hover:bg-[#0069AB] hover:text-white">
                  <Download size={16} />
                  Export
                </button>
              </CSVLink>
            </div>
          </div>

          <div className="border-b border-gray-200 my-5" />

          <div className="flex flex-wrap justify-between items-center gap-3">
            <div className="relative">
              <input
                type="text"
                placeholder="Search..."
                className="pl-10 pr-4 py-2 text-xs border border-gray-300 rounded-lg"
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
              <span className="absolute left-3 top-2.5 text-gray-400">
                <Search size={16} />
              </span>
            </div>
          </div>
        </div>

        <div className="w-full overflow-x-auto">
          <table className="w-full table-fixed border-collapse text-xs">
            <thead className="bg-[#F9FAFB] text-[#667085] border-t border-gray-200">
              <tr>
                <th className="px-3 py-3 text-center font-medium" style={{ width: '50px' }}>No</th>
                <th className="px-3 py-3 text-center font-medium" style={{ width: '200px' }} >Foto & Nama Lengkap</th>
                <th className="px-3 py-3 text-center font-medium">Sekolah</th>
                <th className="px-3 py-3 text-center font-medium" style={{ width: '120px' }}>Tanggal Mulai</th>
                <th className="px-3 py-3 text-center font-medium" style={{ width: '125px' }}>Tanggal Selesai</th>
                <th className="px-3 py-3 text-center font-medium">Email</th>
                <th className="px-3 py-3 text-center font-medium">Aksi</th>
              </tr>
            </thead>

            <tbody>
              {filteredData.map((item, index) => (
                <tr key={item.id} className="border-t border-gray-200 hover:bg-gray-50 text-center">
                  <td className="px-3 py-3" style={{ width: '50px' }}>{index + 1}</td>
                  <td className="px-3 py-3 flex justify-start items-center gap-3">
                    <img src={item.image} alt={item.nama} className="w-10 h-10 rounded-full object-cover" />
                    <span>{item.nama}</span>
                  </td>
                  <td className="px-3 py-3">{item.sekolah}</td>
                  <td className="px-3 py-3" style={{ width: '120px' }}>{item.tanggalMulai}</td>
                  <td className="px-3 py-3" style={{ width: '120px' }}>{item.tanggalSelesai}</td>
                  <td className="px-3 py-3">{item.email}</td>
                  <td className="px-3 py-3 flex justify-center gap-3">
                    <button onClick={() => handlePlace(item)} className="text-green-500 hover:text-green-700 py-1 px-3 border border-green-500 rounded-md text-sm">
                      Tempatkan
                    </button>
                    <button onClick={() => handleChange(item)} className="text-blue-500 hover:text-blue-700 py-1 px-3 border border-blue-500 rounded-md text-sm">
                      Ganti
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Modals */}
      <TempatkanModal
        isOpen={isTempatkanModalOpen}
        onClose={() => setIsTempatkanModalOpen(false)}
        onSimpan={handleSimpanTempatkan}
        data={selectedItem}
      />
      
      <GantiModal
        isOpen={isGantiModalOpen}
        onClose={() => setIsGantiModalOpen(false)}
        onSimpan={handleSimpanGanti}
        data={selectedItem}
      />
    </div>
  );
}