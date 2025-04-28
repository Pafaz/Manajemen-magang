import React, { useState } from 'react';
import Card from "./Card";
import ReactPaginate from 'react-paginate';

export default function DivisiBranchCard() {
  const [branches, setBranches] = useState([
    { id: 1, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 2, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 3, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 4, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 5, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 6, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 7, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 8, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 9, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 10, name: "Solo Project", division: "UI/UX Design", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const itemsPerPage = 12;

  const pageCount = Math.ceil(branches.length / itemsPerPage);
  const displayedBranches = branches.slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage);

  const handlePageClick = (event) => {
    setCurrentPage(event.selected);
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
      <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Kategori Project</h1>
          <div className="flex items-center space-x-2">
            <button 
              onClick={() => setShowModal(true)}
              className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center"
            >
              <i className="bi bi-plus mr-1"></i>
              <span className="mr-1">Tambah Kategori</span>
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
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
          {displayedBranches.map((branch) => (
            <div key={branch.id} className="bg-white border border-[#CED2D9] rounded-lg overflow-hidden pt-2 px-2 pb-2 mb-4">
              <div className="rounded-md overflow-hidden mb-3">
                <img src={branch.backgroundImage} alt="Background" className="w-full h-32 object-cover rounded-md" />
              </div>
              <h3 className="font-bold text-sm text-gray-800">{branch.name}</h3>

              {/* Add border between name and date */}
              <div className="border-t border-[#D5DBE7] mt-2 pt-2">
              <p className="text-xs text-black-500 flex justify-between">
  {/* Divisi di kiri */}
  <span className="flex items-center">
    <i className="bi bi-laptop mr-1 text-blue-500"></i> {branch.division}
  </span>
  
  {/* Date di kanan */}
  <span className="flex items-center">
    <i className="bi bi-calendar-event mr-1 text-blue-500"></i> {branch.date}
  </span>
</p>

              </div>
              <div className="flex justify-center mt-3">
                  <div className="border border-[#D5DBE7] rounded p-2 w-full flex justify-between items-center space-x-2">
                  <button 
                      onClick={() => handleViewDetail(branch.id)}
                      className="text-[#0069AB] border border-[#0069AB] rounded px-3 py-1 text-xs hover:bg-orange-50"
                    >
                      Lihat Detail
                    </button>
                    <button 
                      onClick={() => handleViewDetail(branch.id)}
                      className="text-orange-500 border border-orange-500 rounded px-3 py-1 text-xs hover:bg-orange-50"
                    >
                      Edit
                    </button>
                    <button 
                      onClick={() => handleDeleteClick(branch)}
                      className="text-red-500 border border-red-500 rounded px-3 py-1 text-xs hover:bg-red-100"
                    >
                      Hapus
                    </button>
                  </div>
                </div>
            </div>
          ))}
        </div>

        {/* Pagination */}
        <div className="flex items-center justify-between mt-6">
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
            previousLinkClassName="border border-gray-300 px-4 py-2 text-sm rounded-md text-gray-600 hover:bg-gray-100"
            nextLinkClassName="border border-gray-300 px-4 py-2 text-sm rounded-md text-gray-600 hover:bg-gray-100"
          />
        </div>
      </div>
    </Card>
  );
}
