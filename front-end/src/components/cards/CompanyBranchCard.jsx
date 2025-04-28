import React, { useEffect, useState } from "react";
import Card from "../../components/cards/Card";
import ReactPaginate from "react-paginate";
import ModalTambahAdminCabang from "../../components/modal/ModalTambahAdminCabang";
import ModalDeleteAdminCabang from "../modal/ModalDeleteAdminCabang";
import ModalDetailAdminCabang from "../../components/modal/ModalDetailAdminCabang";

export default function CompanyBranchCard() {
  const [branches, setBranches] = useState([
    {
      id: 1,
      name: "Tomori Nao",
      email: "ini@gmail.com",
      phone: "088819203012",
      role: "Admin Cabang A",
      location: "Tokyo, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 2,
      name: "Nao Tomori",
      email: "contoh@gmail.com",
      phone: "088819203012",
      role: "Admin Cabang B",
      location: "Tokyo, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 3,
      name: "Sakura Minamoto",
      email: "sakura@example.com",
      phone: "081234567890",
      role: "Admin Cabang C",
      location: "Fukuoka, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 4,
      name: "Haruto Tsukishiro",
      email: "haruto@example.com",
      phone: "081234567891",
      role: "Admin Cabang D",
      location: "Osaka, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 5,
      name: "Emilia",
      email: "emilia@example.com",
      phone: "081234567892",
      role: "Admin Cabang E",
      location: "Sapporo, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 6,
      name: "Subaru Natsuki",
      email: "subaru@example.com",
      phone: "081234567893",
      role: "Admin Cabang F",
      location: "Nagoya, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 7,
      name: "Rem",
      email: "rem@example.com",
      phone: "081234567894",
      role: "Admin Cabang G",
      location: "Kobe, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 8,
      name: "Ram",
      email: "ram@example.com",
      phone: "081234567895",
      role: "Admin Cabang H",
      location: "Kyoto, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 9,
      name: "Zero Two",
      email: "zerotwo@example.com",
      phone: "081234567896",
      role: "Admin Cabang I",
      location: "Hokkaido, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 10,
      name: "Ichigo",
      email: "ichigo@example.com",
      phone: "081234567897",
      role: "Admin Cabang J",
      location: "Yokohama, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 11,
      name: "Gojou Satoru",
      email: "gojou@example.com",
      phone: "081234567898",
      role: "Admin Cabang K",
      location: "Shibuya, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 12,
      name: "Megumi Fushiguro",
      email: "megumi@example.com",
      phone: "081234567899",
      role: "Admin Cabang L",
      location: "Sendai, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 13,
      name: "Megumi Fushiguro",
      email: "megumi@example.com",
      phone: "081234567899",
      role: "Admin Cabang L",
      location: "Sendai, Japan",
      backgroundImage: "/assets/img/Cover2.png",
      logoImage: "/assets/img/Profil.png",
    },
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 12;
  const pageCount = Math.ceil(branches.length / itemsPerPage);
  const [modalState, setModalState] = useState({
    showModal: false,
    showDeleteModal: false,
    branchToDelete: null,
    showDetailModal: false, // Tampilkan modal detail
    branchToDetail: null, // Menyimpan cabang yang dipilih untuk detail
  });
  const handlePageClick = (event) => {
    setCurrentPage(event.selected);
  };

  const displayedBranches = branches.slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage);

  const handleAddBranch = (branchData) => {
    const newBranch = {
      id: branches.length + 1,
      name: branchData.name,
      email: branchData.email,
      phone: branchData.phone || "088819203012",
      role: branchData.role || "Admin Cabang",
      location: `${branchData.city}, ${branchData.province}`,
      address: "0 Peserta Magang",
      backgroundImage: "/assets/img/Cover.png",
      logoImage: "/assets/img/logoperusahaan.png",
    };
    setBranches([...branches, newBranch]);
    setModalState({ ...modalState, showModal: false });
  };

  const handleViewDetail = (branch) => {
    setModalState({
      ...modalState,
      showDetailModal: true, // Tampilkan modal detail
      branchToDetail: branch, // Set branch yang akan ditampilkan di modal
    });
  };

  // Handle delete button click
  const handleDeleteClick = (branch) => {
    setModalState({ ...modalState, showDeleteModal: true, branchToDelete: branch });
  };

  // Handle actual delete of branch
  const handleDeleteBranch = () => {
    setBranches(branches.filter((branch) => branch.id !== modalState.branchToDelete.id));
    setModalState({ ...modalState, showDeleteModal: false, branchToDelete: null });
  };

  // Close delete modal
  const handleCloseDeleteModal = () => {
    setModalState({ ...modalState, showDeleteModal: false, branchToDelete: null });
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
        {/* Header section */}
        <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Admin</h1>
          <div className="flex items-center space-x-2">
            <button onClick={() => setModalState({ ...modalState, showModal: true })} className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center">
              <i className="bi bi-plus mr-1"></i>
              <span className="mr-1">Tambah Admin</span>
            </button>
            <div className="flex items-center">
              <span className="mr-1 text-xs">Sort by:</span>
              <select className="border border-gray-300 rounded-md px-2 py-1 text-xs">
                <option>Terbaru</option>
                <option>Terlama</option>
              </select>
            </div>
          </div>
        </div>

        {/* Branch cards grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          {displayedBranches.map((branch) => (
            <div key={branch.id} className="bg-white border border-[#D5DBE7] rounded-lg overflow-hidden">
              <div className="relative">
                <img src={branch.backgroundImage} alt="Company Building" className="w-full h-32 object-cover" />
                <div className="absolute -bottom-4 left-0 right-0 flex justify-center">
                  <div className="rounded-full overflow-hidden border-2 border-white bg-white w-16 h-16">
                    <img src={branch.logoImage} alt="Company Logo" className="w-full h-full object-cover" />
                  </div>
                </div>
              </div>

              <div className="pt-8 px-3 pb-4">
                <h3 className="font-bold text-sm text-gray-800 text-center mb-2">{branch.name}</h3>
                {/* <p className="text-xs text-gray-600 text-center mb-1">{branch.role}</p> */}
                <p className="text-xs text-black-600 text-center mb-1">{branch.email}</p>

                <div className="flex justify-center mt-3">
                  <div className="border border-[#D5DBE7] rounded p-2 w-full flex justify-between items-center space-x-2">
                    <button
                      onClick={() => handleViewDetail(branch)} // Show modal on click
                      className="text-blue-500 border border-blue-500 rounded px-3 py-1 text-xs hover:bg-blue-50"
                    >
                      Lihat Detail
                    </button>
                    <button className="text-orange-500 border border-orange-500 rounded px-3 py-1 text-xs hover:bg-orange-50">Edit</button>
                    <button onClick={() => handleDeleteClick(branch)} className="text-red-500 border border-red-500 rounded px-3 py-1 text-xs hover:bg-red-50">
                      Hapus
                    </button>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Pagination */}
        <div className="flex items-center justify-between mt-6">
          <div className="flex-1">
            <ReactPaginate
              previousLabel="← Sebelumnya"
              nextLabel="Berikutnya →"
              breakLabel="..."
              pageCount={pageCount}
              marginPagesDisplayed={2}
              pageRangeDisplayed={3}
              onPageChange={handlePageClick}
              containerClassName="flex justify-center items-center space-x-2"
              pageLinkClassName="px-3 py-1 text-sm rounded-md text-gray-700 hover:bg-blue-100"
              activeLinkClassName="bg-blue-500 text-white"
              previousClassName="mr-auto"
              nextClassName="ml-auto"
              previousLinkClassName="border border-gray-300 px-4 py-2 text-sm rounded-md text-gray-600 hover:bg-gray-100"
              nextLinkClassName="border border-gray-300 px-4 py-2 text-sm rounded-md text-gray-600 hover:bg-gray-100"
            />
          </div>
        </div>
      </div>

      {/* Modals */}
      <ModalTambahAdminCabang isOpen={modalState.showModal} onClose={() => setModalState({ ...modalState, showModal: false })} onSave={handleAddBranch} />

      {/* Modal for deleting branch */}
      <ModalDeleteAdminCabang isOpen={modalState.showDeleteModal} onClose={handleCloseDeleteModal} onConfirm={handleDeleteBranch} />

      {/* Modal for displaying branch details */}
      <ModalDetailAdminCabang
        isOpen={modalState.showDetailModal}
        onClose={() => setModalState({ ...modalState, showDetailModal: false })}
        branch={modalState.branchToDetail} // Pass the selected branch data to the modal
      />
    </Card>
  );
}
