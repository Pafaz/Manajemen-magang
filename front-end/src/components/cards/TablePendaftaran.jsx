import React, { useState } from "react";

export default function TablePendaftaran({ data, searchTerm, selectedDate }) {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);

  const filteredData = data.filter((item) => {
    const isMatchSearch =
      item.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.jurusan.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.kelas.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.masaMagang.toLowerCase().includes(searchTerm.toLowerCase()) ||
      item.sekolah.toLowerCase().includes(searchTerm.toLowerCase());

    const isMatchDate = selectedDate
      ? new Date(item.masaMagang).toLocaleDateString() ===
        selectedDate.toLocaleDateString()
      : true;

    return isMatchSearch && isMatchDate;
  });

  const openModal = (item) => {
    setSelectedItem(item);
    setIsModalOpen(true);
    document.body.classList.add("modal-open");
  };

  const closeModal = () => {
    setIsModalOpen(false);
    setSelectedItem(null);
    document.body.classList.remove("modal-open");
  };

  return (
    <div className="w-full overflow-x-auto">
      <style jsx global>{`
        .modal-open::before {
          content: "";
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: rgba(0, 0, 0, 0.15);
          z-index: 40;
        }
      `}</style>

      <table className="w-full table-fixed border-collapse text-sm">
        <thead className="bg-[#F9FAFB] text-[#667085] border-t border-gray-200">
          <tr>
            <th className="px-3 py-3 text-center font-medium">No</th>
            <th className="px-3 py-3 text-center font-medium">Nama</th>
            <th className="px-3 py-3 text-center font-medium">Jurusan</th>
            <th className="px-3 py-3 text-center font-medium">Kelas</th>
            <th className="px-3 py-3 text-center font-medium">Masa Magang</th>
            <th className="px-3 py-3 text-center font-medium">Sekolah</th>
            <th className="px-3 py-3 text-center font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody>
          {filteredData.map((item, index) => (
            <tr
              key={item.id}
              className="border-t border-gray-200 hover:bg-gray-50 text-center"
            >
              <td className="px-3 py-3">{index + 1}</td>
              <td className="px-3 py-3 flex items-center gap-2 justify-center">
                <img
                  src={item.image}
                  alt={item.nama}
                  className="w-8 h-8 rounded-full"
                />
                {item.nama}
              </td>
              <td className="px-3 py-3">{item.jurusan}</td>
              <td className="px-3 py-3">{item.kelas}</td>
              <td className="px-3 py-3">{item.masaMagang}</td>
              <td className="px-3 py-3">{item.sekolah}</td>
              <td
                className="px-3 py-3 text-[#0069AB] cursor-pointer"
                onClick={() => openModal(item)}
              >
                Lihat
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      {isModalOpen && (
        <div
          className="fixed inset-0 z-[999] flex items-center justify-center bg-black/50"
          onClick={(e) => {
            if (e.target === e.currentTarget) {
              closeModal();
            }
          }}
        >
          <div
            className="bg-white rounded-lg max-w-md w-full p-6 shadow-lg pointer-events-auto"
            onClick={(e) => e.stopPropagation()}
          >
            <div className="flex justify-between items-center">
              <h2 className="text-lg font-semibold">Detail Approval</h2>
              <button
                onClick={closeModal}
                className="text-gray-500 hover:text-gray-700"
              >
                <svg
                  className="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M6 18L18 6M6 6l12 12"
                  ></path>
                </svg>
              </button>
            </div>

            <div className="mt-4 flex flex-col">
              <img
                src={selectedItem.image}
                alt={selectedItem.nama}
                className="w-24 h-24 rounded-lg object-cover"
              />
              <div className="mt-2">
                <h3 className="font-bold text-lg">{selectedItem.nama}</h3>
                <p className="text-gray-500">Web Developer</p>
              </div>
            </div>

            <div className="mt-6 space-y-4">
              <div className="flex">
                <span className="text-gray-600 w-40">Jurusan</span>
                <span>{selectedItem.jurusan}</span>
              </div>

              <div className="flex">
                <span className="text-gray-600 w-40">Kelas</span>
                <span>{selectedItem.kelas}</span>
              </div>

              <div className="flex">
                <span className="text-gray-600 w-40">Sekolah</span>
                <span>{selectedItem.sekolah}</span>
              </div>

              <div className="flex">
                <span className="text-gray-600 w-40">Status Pendaftaran</span>
                <span>Belum diproses</span>
              </div>

              <div>
                <span className="text-gray-600 block mb-2">Berkas Pendaftaran</span>
                <div className="flex flex-wrap gap-2">
                  {selectedItem.berkas.map((file, i) => (
                    <a
                      key={i}
                      href={file.url}
                      target="_blank"
                      className="bg-gray-100 text-gray-600 px-3 py-1 rounded text-sm"
                    >
                      {file.nama}
                    </a>
                  ))}
                </div>
              </div>

              <div>
                <span className="text-gray-600 block mb-2">
                  Alasan Penolakan
                </span>
                <textarea
                  className="w-full border border-gray-300 rounded p-2 min-h-20"
                  placeholder="Alasan Penolakan"
                ></textarea>
              </div>
            </div>

            <div className="mt-6 flex justify-between space-x-4">
              <button
                className="flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                onClick={closeModal}
              >
                <i className="bi bi-x-circle-fill mr-2"></i>
                Tolak
              </button>

              <button
                className="flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                onClick={closeModal}
              >
                <i className="bi bi-check-circle-fill mr-2"></i>
                Terima
              </button>

              <button
                className="flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                onClick={closeModal}
              >
                <i className="bi bi-slash-circle-fill mr-2"></i>
                Blokir
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
