import React, { useState } from 'react';
import Card from "./Card";
import Penempatan from './Penempatan';

export default function DivisiBranchCard() {
  const [branches, setBranches] = useState([
    { id: 1, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 2, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 3, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
    { id: 4, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024" },
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const [showModal, setShowModal] = useState(false);
  const [newDivision, setNewDivision] = useState({
    name: "",
    kategori: "",
    tags: []
  });
  const [selectedFile, setSelectedFile] = useState(null);
  const itemsPerPage = 12;

  const pageCount = Math.ceil(branches.length / itemsPerPage);
  const displayedBranches = branches.slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage);

  const handlePageClick = (event) => {
    setCurrentPage(event.selected);
  };

  const handleAddDivision = () => {
    // Generate a new ID (usually this would come from the backend)
    const newId = branches.length > 0 ? Math.max(...branches.map(branch => branch.id)) + 1 : 1;
    
    // Create new division object
    const newBranch = {
      id: newId,
      name: newDivision.name,
      backgroundImage: selectedFile ? URL.createObjectURL(selectedFile) : "/assets/img/Cover3.png",
      date: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
    };
    
    // Add to branches array
    setBranches([...branches, newBranch]);
    
    // Reset form and close modal
    setNewDivision({ name: "", kategori: "", tags: [] });
    setSelectedFile(null);
    setShowModal(false);
  };

  const handleViewDetail = (id) => {
    // Handle view detail logic
    console.log(`Viewing detail for division with id: ${id}`);
  };

  const handleDeleteClick = (branch) => {
    // Handle delete logic
    console.log(`Deleting division: ${branch.name}`);
  };

  const handleTagClick = (tag) => {
    // Add or remove tag from the tags array
    if (newDivision.tags.includes(tag)) {
      setNewDivision({
        ...newDivision,
        tags: newDivision.tags.filter(t => t !== tag)
      });
    } else {
      setNewDivision({
        ...newDivision,
        tags: [...newDivision.tags, tag]
      });
    }
  };

  const handleFileChange = (e) => {
    if (e.target.files && e.target.files[0]) {
      setSelectedFile(e.target.files[0]);
    }
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
        <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Divisi Terdaftar</h1>
          <div className="flex items-center space-x-2">
            <button 
              onClick={() => setShowModal(true)}
              className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center"
            >
              <i className="bi bi-plus mr-1"></i>
              <span className="mr-1">Tambah Divisi</span>
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
      </div>
      <Penempatan/>

      {/* Modal for adding a new division */}
      {showModal && (
        <div className="fixed inset-0 flex items-center justify-center z-50">
          <div className="absolute inset-0 bg-black opacity-50" onClick={() => setShowModal(false)}></div>
          <div className="bg-white rounded-lg w-full max-w-md mx-4 z-50">
            <div className="p-6">
              <h2 className="text-xl font-bold mb-6">Tambahkan Divisi Baru</h2>
              
              <div className="mb-4">
                <label className="block text-sm font-medium mb-2">Nama Divisi</label>
                <input 
                  type="text" 
                  className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  value={newDivision.name}
                  onChange={(e) => setNewDivision({...newDivision, name: e.target.value})}
                />
              </div>
              
              <div className="mb-4">
                <label className="block text-sm font-medium mb-2">Kategori Project</label>
                <input 
                  type="text" 
                  className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"
                  value={newDivision.kategori}
                  onChange={(e) => setNewDivision({...newDivision, kategori: e.target.value})}
                />
              </div>
              
              <div className="flex flex-wrap gap-2 mb-4">
                <button 
                  className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes('Tahap Pengenalan') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'}`}
                  onClick={() => handleTagClick('Tahap Pengenalan')}
                >
                  Tahap Pengenalan {newDivision.tags.includes('Tahap Pengenalan') && <span className="ml-1">×</span>}
                </button>
                <button 
                  className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes('Tahap Dasar') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'}`}
                  onClick={() => handleTagClick('Tahap Dasar')}
                >
                  Tahap Dasar {newDivision.tags.includes('Tahap Dasar') && <span className="ml-1">×</span>}
                </button>
                <button 
                  className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes('Tahap Pre Mini') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'}`}
                  onClick={() => handleTagClick('Tahap Pre Mini')}
                >
                  Tahap Pre Mini {newDivision.tags.includes('Tahap Pre Mini') && <span className="ml-1">×</span>}
                </button>
                <button 
                  className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes('Tahap Mini Project') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'}`}
                  onClick={() => handleTagClick('Tahap Mini Project')}
                >
                  Tahap Mini Project {newDivision.tags.includes('Tahap Mini Project') && <span className="ml-1">×</span>}
                </button>
                <button 
                  className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes('Tahap Big Project') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'}`}
                  onClick={() => handleTagClick('Tahap Big Project')}
                >
                  Tahap Big Project {newDivision.tags.includes('Tahap Big Project') && <span className="ml-1">×</span>}
                </button>
              </div>
              
              <div className="mb-6">
                <label className="block text-sm font-medium mb-2">Foto Header</label>
                <div className="border border-gray-300 rounded-md overflow-hidden">
                  <div className="flex">
                    <label className="bg-gray-50 text-blue-600 px-4 py-2 text-sm cursor-pointer">
                      Choose File
                      <input 
                        type="file" 
                        accept="image/*"
                        className="hidden" 
                        onChange={handleFileChange}
                      />
                    </label>
                    <span className="flex-1 p-2 text-sm text-gray-500">
                      {selectedFile ? selectedFile.name : 'No File Chosen'}
                    </span>
                  </div>
                </div>
              </div>
              
              <div className="flex justify-end gap-3">
                <button 
                  onClick={() => setShowModal(false)}
                  className="px-4 py-2 text-sm border border-gray-300 rounded-md"
                >
                  Batal
                </button>
                <button 
                  onClick={handleAddDivision}
                  className="px-4 py-2 text-sm bg-blue-600 text-white rounded-md"
                >
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
      <Penempatan/>
    </Card>
  );
}