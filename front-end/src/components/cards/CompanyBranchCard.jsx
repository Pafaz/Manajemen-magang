import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Card from "../../components/cards/Card";
import ReactPaginate from 'react-paginate';
import ModalTambahCabang from "../../components/modal/ModalTambahCabang";
import ModalDeleteAdminCabang from "../../components/modal/ModalDeleteAdminCabang"; // Import the new component

export default function CompanyBranchCard() {
  const navigate = useNavigate();
  
  const [branches, setBranches] = useState([
    { id: 1, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 2, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 3, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 4, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 5, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 6, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 7, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 8, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 9, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 10, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 11, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 12, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 13, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 14, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 15, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 16, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },
    { id: 17, name: "Nao Tomori", email: "contoh@gmail.com", backgroundImage: "/assets/img/Cover2.png", logoImage: "/assets/img/Profil.png" },

    // ... other branches
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 12;
  const pageCount = Math.ceil(branches.length / itemsPerPage);

  const [showModal, setShowModal] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [branchToDelete, setBranchToDelete] = useState(null);

  const handlePageClick = (event) => {
    setCurrentPage(event.selected);
  };

  const displayedBranches = branches.slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage);

  // Function to handle adding a new branch
  const handleAddBranch = (branchData) => {
    const newBranch = {
      id: branches.length + 1,
      name: branchData.name,
      location: `${branchData.city}, ${branchData.province}`,
      address: "0 Peserta Magang",
      backgroundImage: "/assets/img/Cover.png",
      logoImage: "/assets/img/logoperusahaan.png",
    };
    setBranches([...branches, newBranch]);
    setShowModal(false);
  };

  // Function to navigate to the detail page
  const handleViewDetail = (branchId) => {
    navigate(`/perusahaan/cabang/${branchId}`);
  };

  // Handle delete button click
  const handleDeleteClick = (branch) => {
    setBranchToDelete(branch);
    setShowDeleteModal(true);
  };

  // Handle actual delete of branch
  const handleDeleteBranch = () => {
    setBranches(branches.filter(branch => branch.id !== branchToDelete.id));
    setShowDeleteModal(false);
    setBranchToDelete(null);
  };

  // Close delete modal
  const handleCloseDeleteModal = () => {
    setShowDeleteModal(false);
    setBranchToDelete(null);
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
        {/* Header section */}
        <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Admin Cabang</h1>
          <div className="flex items-center space-x-2">
            <button 
              onClick={() => setShowModal(true)}
              className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center"
            >
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
                <p className="text-xs text-black-600 text-center mb-1">{branch.email}</p>

                <div className="flex justify-center mt-3">
                  <div className="border border-[#D5DBE7] rounded p-2 w-full flex justify-between items-center space-x-2">
                    <button 
                      onClick={() => handleViewDetail(branch.id)}
                      className="text-blue-500 border border-blue-500 rounded px-3 py-1 text-xs hover:bg-blue-50"
                    >
                      Lihat Detail
                    </button>
                    <button className="text-orange-500 border border-orange-500 rounded px-3 py-1 text-xs hover:bg-orange-50">Edit</button>
                    <button 
                      onClick={() => handleDeleteClick(branch)}
                      className="text-red-500 border border-red-500 rounded px-3 py-1 text-xs hover:bg-red-50"
                    >
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
      <ModalTambahCabang 
        isOpen={showModal}
        onClose={() => setShowModal(false)}
        onSave={handleAddBranch}
      />

      {/* Using the extracted ModalDeleteAdminCabang component */}
      <ModalDeleteAdminCabang 
        isOpen={showDeleteModal}
        onClose={handleCloseDeleteModal}
        onConfirm={handleDeleteBranch}
      />
    </Card>
  );
}