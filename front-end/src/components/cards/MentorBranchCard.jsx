import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import Card from "./Card";
import ReactPaginate from "react-paginate";
import ModalTambahMentor from "../../components/modal/ModalTambahMentor";
import ModalDelete from "../../components/modal/ModalDeleteAdminCabang";
import ModalDetailMentor from "../../components/modal/ModalDetailMentor";

export default function MentorBranchCard() {
  const navigate = useNavigate();
  const [selectedMentor, setSelectedMentor] = useState(null);
  const [isDetailModalOpen, setIsDetailModalOpen] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingMentor, setEditingMentor] = useState(null);
  const [modalState, setModalState] = useState({
    showDeleteModal: false,
    selectedBranchId: null,
  });

  const [branches, setBranches] = useState([
    {
      id: 1,
      name: "Nao Tomori",
      email: "nao1@gmail.com",
      division: "UI/UX",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 2,
      name: "Shiba Inuko",
      email: "shiba2@gmail.com",
      division: "Web Developer",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 3,
      name: "Sakura Yamauchi",
      email: "sakura3@gmail.com",
      division: "Mobile",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 4,
      name: "Hinata Shoyo",
      email: "hinata4@gmail.com",
      division: "Digital Marketing",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 5,
      name: "Kageyama Tobio",
      email: "kageyama5@gmail.com",
      division: "Web Developer",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 6,
      name: "Kanao Tsuyuri",
      email: "kanao6@gmail.com",
      division: "UI/UX",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 7,
      name: "Ayanami Rei",
      email: "rei7@gmail.com",
      division: "Mobile",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 8,
      name: "Shinji Ikari",
      email: "shinji8@gmail.com",
      division: "Digital Marketing",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 9,
      name: "Misato Katsuragi",
      email: "misato9@gmail.com",
      division: "UI/UX",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 10,
      name: "Levi Ackerman",
      email: "levi10@gmail.com",
      division: "Web Developer",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 11,
      name: "Eren Yeager",
      email: "eren11@gmail.com",
      division: "Mobile",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 12,
      name: "Mikasa Ackerman",
      email: "mikasa12@gmail.com",
      division: "Digital Marketing",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
    {
      id: 13,
      name: "Armin Arlert",
      email: "armin13@gmail.com",
      division: "UI/UX",
      backgroundImage: "/assets/img/Cover2.jpeg",
      logoImage: "/assets/img/Profil.png",
    },
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 12;
  const [selectedDivision, setSelectedDivision] = useState("All");

  const filteredBranches =
    selectedDivision === "All"
      ? branches
      : branches.filter((branch) => branch.division === selectedDivision);

  const pageCount = Math.ceil(filteredBranches.length / itemsPerPage);
  const displayedBranches = filteredBranches.slice(
    currentPage * itemsPerPage,
    (currentPage + 1) * itemsPerPage
  );

  const handleEditMentor = (mentor) => {
    setEditingMentor(mentor);
    setIsModalOpen(true);
  };

  const handlePageClick = (event) => {
    setCurrentPage(event.selected);
  };

  const handleViewDetail = (branchId) => {
<<<<<<< HEAD
    navigate(`/perusahaan/mentor/${branchId}`);
=======
    const mentor = branches.find((b) => b.id === branchId);
    setSelectedMentor(mentor);
    setIsDetailModalOpen(true);
>>>>>>> bc9825108818e07069de094dd287122ae57365ee
  };

  const handleSaveMentor = (mentorData) => {
    if (editingMentor) {
      // Edit existing mentor
      const updatedBranches = branches.map((branch) =>
        branch.id === editingMentor.id
          ? { ...branch, ...mentorData }
          : branch
      );
      setBranches(updatedBranches);
    } else {
      // Add new mentor
      const newMentor = {
        id: branches.length + 1,
        ...mentorData,
        backgroundImage: "/assets/img/Cover2.jpeg",
        logoImage: "/assets/img/Profil.png",
      };
      setBranches([...branches, newMentor]);
    }
  
    setIsModalOpen(false);
    setEditingMentor(null);
  };
  

  const handleOpenDeleteModal = (branchId) => {
    setModalState({
      showDeleteModal: true,
      selectedBranchId: branchId,
    });
  };

  const handleCloseDeleteModal = () => {
    setModalState({
      showDeleteModal: false,
      selectedBranchId: null,
    });
  };

  const handleDeleteBranch = () => {
    const updatedBranches = branches.filter(
      (branch) => branch.id !== modalState.selectedBranchId
    );
    setBranches(updatedBranches);
    handleCloseDeleteModal();
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
        <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Mentor Terdaftar</h1>
          <div className="flex items-center space-x-2">
            <button
              onClick={() => setIsModalOpen(true)}
              className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center"
            >
              <i className="bi bi-plus mr-1"></i>
              <span className="mr-1">Tambah Mentor</span>
            </button>
            <select
              className="border border-gray-300 rounded-md px-2 py-1 text-xs"
              value={selectedDivision}
              onChange={(e) => {
                setSelectedDivision(e.target.value);
                setCurrentPage(0);
              }}
            >
              <option value="All">Semua Divisi</option>
              <option value="UI/UX">UI/UX</option>
              <option value="Web Developer">Web Developer</option>
              <option value="Mobile">Mobile</option>
              <option value="Digital Marketing">Digital Marketing</option>
            </select>
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          {displayedBranches.map((branch) => (
            <div
              key={branch.id}
              className="bg-white border border-[#D5DBE7] rounded-lg overflow-hidden"
            >
              <div className="relative">
                <img
                  src={branch.backgroundImage}
                  alt="Background"
                  className="w-full h-32 object-cover"
                />
                <div className="absolute -bottom-4 left-0 right-0 flex justify-center">
                  <div className="rounded-full overflow-hidden border-2 border-white bg-white w-16 h-16">
                    <img
                      src={branch.logoImage}
                      alt="Logo"
                      className="w-full h-full object-cover"
                    />
                  </div>
                </div>
              </div>
              <div className="pt-8 px-3 pb-4">
                <h3 className="font-bold text-sm text-gray-800 text-center mb-1">
                  {branch.name}
                </h3>
                <p className="text-xs text-black-500 text-center mb-3 italic">
                  {branch.division}
                </p>
                <p className="text-xs text-black-600 text-center mb-1">
                  {branch.email}
                </p>
                <div className="flex justify-center mt-2">
                  <div className="border border-[#D5DBE7] rounded p-2 w-full flex justify-between items-center space-x-2">
                    <button
                      onClick={() => handleViewDetail(branch.id)}
                      className="text-blue-500 border border-blue-500 rounded px-3 py-1 text-xs hover:bg-blue-50"
                    >
                      Lihat Detail
                    </button>
                    <button
                      onClick={() => handleEditMentor(branch)}
                      className="text-orange-500 border border-orange-500 rounded px-3 py-1 text-xs hover:bg-orange-50"
                    >
                      Edit
                    </button>
                    <button
                      onClick={() => handleOpenDeleteModal(branch.id)}
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

        {/* Modal tambah mentor */}
        <ModalTambahMentor
          isOpen={isModalOpen}
          onClose={() => {
            setIsModalOpen(false);
            setEditingMentor(null);
          }}
          onSave={handleSaveMentor}
          mode={editingMentor ? "edit" : "add"}
          mentorData={editingMentor}
        />

        {/* Modal delete mentor */}
        <ModalDelete
          isOpen={modalState.showDeleteModal}
          onClose={handleCloseDeleteModal}
          onConfirm={handleDeleteBranch}
        />
        <ModalDetailMentor
          isOpen={isDetailModalOpen}
          onClose={() => setIsDetailModalOpen(false)}
          mentor={selectedMentor}
        />
      </div>
    </Card>
  );
}
