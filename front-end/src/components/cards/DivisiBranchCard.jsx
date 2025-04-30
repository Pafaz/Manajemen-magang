import React, { useState } from "react";
import Card from "./Card";
import TempatkanModal from "../modal/TempatkanModal";
import Penempatan from "./Penempatan";
import Detaildivisi from "../modal/WebDevModal";
import WebDevModal from "../modal/WebDevModal";

export default function DivisiBranchCard() {
  const [branches, setBranches] = useState([
    { id: 1, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024", categories: ["Frontend", "Backend"] },
    { id: 2, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024", categories: ["UI/UX"] },
    { id: 3, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024", categories: ["Mobile Development"] },
    { id: 4, name: "Solo Project", backgroundImage: "/assets/img/Cover3.png", date: "24 Maret 2024", categories: ["Data Science", "AI"] },
  ]);

  const [currentPage, setCurrentPage] = useState(0);
  const [showModal, setShowModal] = useState(false);
  const [newDivision, setNewDivision] = useState({
    name: "",
    categories: [],
    tags: [],
  });
  const [categoryInput, setCategoryInput] = useState("");
  const [selectedFile, setSelectedFile] = useState(null);
  const itemsPerPage = 12;
  const [isTempatkanModalOpen, setIsTempatkanModalOpen] = useState(false);
  const [isDetaildivisiOpen, setIsDetaildivisiOpen] = useState(false);
  const [isWebDevModalOpen, setIsWebDevModalOpen] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);

  const pageCount = Math.ceil(branches.length / itemsPerPage);
  const displayedBranches = branches.slice(currentPage * itemsPerPage, (currentPage + 1) * itemsPerPage);

  const handlePageClick = (pageNumber) => {
    setCurrentPage(pageNumber);
  };

  const handleAddDivision = () => {
    const newId = branches.length > 0 ? Math.max(...branches.map((branch) => branch.id)) + 1 : 1;

    const newBranch = {
      id: newId,
      name: newDivision.name,
      backgroundImage: selectedFile ? URL.createObjectURL(selectedFile) : "/assets/img/Cover3.png",
      date: new Date().toLocaleDateString("id-ID", { day: "2-digit", month: "long", year: "numeric" }),
      categories: newDivision.categories,
    };

    setBranches([...branches, newBranch]);

    setNewDivision({ name: "", categories: [], tags: [] });
    setCategoryInput("");
    setSelectedFile(null);
    setShowModal(false);
  };

  const handleViewDetail = (id) => {
    const item = branches.find((branch) => branch.id === id);
    if (item) {
      setSelectedItem(item);
      setIsDetaildivisiOpen(true);
    }
    console.log(`Viewing detail for division with id: ${id}`);
  };

  const handleDeleteClick = (branch) => {
    if (window.confirm(`Apakah Anda yakin ingin menghapus divisi "${branch.name}"?`)) {
      const updatedBranches = branches.filter((item) => item.id !== branch.id);
      setBranches(updatedBranches);
      console.log(`Deleting division: ${branch.name}`);
    }
  };

  const handleTagClick = (tag) => {
    if (newDivision.tags.includes(tag)) {
      setNewDivision({
        ...newDivision,
        tags: newDivision.tags.filter((t) => t !== tag),
      });
    } else {
      setNewDivision({
        ...newDivision,
        tags: [...newDivision.tags, tag],
      });
    }
  };

  const handleFileChange = (e) => {
    if (e.target.files && e.target.files[0]) {
      setSelectedFile(e.target.files[0]);
    }
  };

  const handlePlace = (item) => {
    setSelectedItem(item);
    setIsTempatkanModalOpen(true);
  };

  const handleSimpanTempatkan = (formData) => {
    console.log("Tempatkan data:", formData);
    setIsTempatkanModalOpen(false);
  };

  const handleSimpanDivisi = (formData) => {
    console.log("Detail divisi data:", formData);
    if (formData && formData.id) {
      const updatedBranches = branches.map((branch) => (branch.id === formData.id ? { ...branch, ...formData } : branch));
      setBranches(updatedBranches);
    }
    setIsDetaildivisiOpen(false);
  };

  const handleImageClick = (branch) => {
    console.log(`Image clicked for: ${branch.name}`);
    setSelectedItem(branch);
    setIsWebDevModalOpen(true);
  };

  // Handle adding a category
  const handleAddCategory = () => {
    const category = categoryInput.trim();
    if (category && !newDivision.categories.includes(category)) {
      setNewDivision({
        ...newDivision,
        categories: [...newDivision.categories, category],
      });
    }
    setCategoryInput("");
  };

  // Handle removing a category
  const handleRemoveCategory = (category) => {
    setNewDivision({
      ...newDivision,
      categories: newDivision.categories.filter((c) => c !== category),
    });
  };

  // Handle input change for category field
  const handleCategoryInputChange = (e) => {
    setCategoryInput(e.target.value);
  };

  // Handle key press for category input
  const handleCategoryKeyPress = (e) => {
    if (e.key === "Enter" && categoryInput.trim()) {
      e.preventDefault();
      handleAddCategory();
    }
  };

  return (
    <Card>
      <div className="mt-8 px-1 pb-6">
        <div className="flex justify-between items-center mb-4">
          <h1 className="text-xl font-bold">Divisi Terdaftar</h1>
          <div className="flex items-center space-x-2">
            <button onClick={() => setShowModal(true)} className="bg-white text-gray-700 border border-gray-300 rounded-md px-2 py-1 text-xs flex items-center">
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
                <img src={branch.backgroundImage} alt="Background" className="w-full h-32 object-cover rounded-md cursor-pointer hover:opacity-90 transition-opacity" onClick={() => handleImageClick(branch)} />
              </div>
              <h3 className="font-bold text-sm text-gray-800">{branch.name}</h3>

              {/* Display categories below name */}
              {branch.categories && branch.categories.length > 0 && (
                <div className="flex flex-wrap gap-1 mt-1">
                  {branch.categories.map((category, index) => (
                    <span key={index} className="bg-blue-100 text-blue-700 text-xs rounded-md px-2 py-0.5">
                      {category}
                    </span>
                  ))}
                </div>
              )}

              <div className="border-t border-[#D5DBE7] mt-2 pt-2">
                <p className="text-xs text-black-500 flex justify-between">
                  <span className="flex items-center">
                    <i className="bi bi-calendar-event mr-1 text-blue-500"></i> {branch.date}
                  </span>
                </p>
              </div>
              <div className="flex justify-center mt-3">
                <div className="border border-[#D5DBE7] rounded p-2 w-full flex justify-between items-center space-x-2">
                  <button onClick={() => handlePlace(branch)} className="text-[#0069AB] border border-[#0069AB] rounded px-3 py-1 text-xs hover:bg-orange-50">
                    Tempatkan
                  </button>
                  <button onClick={() => handleViewDetail(branch.id)} className="text-orange-500 border border-orange-500 rounded px-3 py-1 text-xs hover:bg-orange-50">
                    Edit
                  </button>
                  <button onClick={() => handleDeleteClick(branch)} className="text-red-500 border border-red-500 rounded px-3 py-1 text-xs hover:bg-red-100">
                    Hapus
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Pagination UI */}
        {pageCount > 1 && (
          <div className="flex justify-center mt-6">
            <div className="flex space-x-2">
              {Array.from({ length: pageCount }).map((_, index) => (
                <button key={index} onClick={() => handlePageClick(index)} className={`px-3 py-1 rounded ${currentPage === index ? "bg-blue-600 text-white" : "bg-gray-200 text-gray-700 hover:bg-gray-300"}`}>
                  {index + 1}
                </button>
              ))}
            </div>
          </div>
        )}
      </div>

      <Penempatan />

      {/* Modal for adding a new division */}
      {showModal && (
        <div className="fixed inset-0 flex items-center justify-center z-50">
          <div className="absolute inset-0 bg-black opacity-50" onClick={() => setShowModal(false)}></div>
          <div className="bg-white rounded-lg w-full max-w-md mx-4 z-50">
            <div className="p-6">
              <h2 className="text-xl font-bold mb-6">Tambahkan Divisi Baru</h2>
              <div className="mb-4">
                <label className="block text-sm font-medium mb-2">Nama Divisi</label>
                <input type="text" className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" value={newDivision.name} onChange={(e) => setNewDivision({ ...newDivision, name: e.target.value })} />
              </div>

              <div className="mb-4">
                <label className="block text-sm font-medium mb-2">Kategori Project</label>
                <div className="flex border border-gray-300 rounded-md bg-white overflow-hidden focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400">
                  <input type="text" className="flex-1 px-3 py-2 text-sm focus:outline-none" value={categoryInput} onChange={handleCategoryInputChange} onKeyPress={handleCategoryKeyPress} placeholder="Tambahkan kategori..." />
                  {/* <button 
                    className="px-3 bg-gray-100 text-blue-600 hover:bg-gray-200 text-sm"
                    onClick={handleAddCategory}
                  >
                    Tambah
                  </button> */}
                </div>

                {/* Display selected categories */}
                {newDivision.categories.length > 0 && (
                  <div className="flex flex-wrap gap-2 mt-3">
                    {newDivision.categories.map((category, index) => (
                      <div key={index} className="bg-blue-100 text-blue-700 text-xs rounded-md px-3 py-1 flex items-center">
                        {category}
                        <button className="ml-2 text-blue-500 hover:text-blue-700" onClick={() => handleRemoveCategory(category)}>
                          ×
                        </button>
                      </div>
                    ))}
                  </div>
                )}
              </div>

              {/* Tags Section */}
              <div className="flex flex-wrap gap-2 mb-4">
                <button className={`px-3 py-1 text-xs rounded-md ${newDivision.tags.includes("") ? "bg-blue-100 text-blue-700" : "bg-gray-100 text-gray-700"}`} onClick={() => handleTagClick("")}></button>
                {/* More tag buttons go here */}
              </div>

              <div className="mb-6">
                <label className="block text-sm font-medium mb-2">Foto Header</label>
                <div className="border border-gray-300 rounded-md overflow-hidden">
                  <div className="flex">
                    <label className="bg-gray-50 text-blue-600 px-4 py-2 text-sm cursor-pointer">
                      Choose File
                      <input type="file" accept="image/*" className="hidden" onChange={handleFileChange} />
                    </label>
                    <span className="flex-1 p-2 text-sm text-gray-500">{selectedFile ? selectedFile.name : "No File Chosen"}</span>
                  </div>
                </div>
              </div>

              <div className="flex justify-end gap-3">
                <button onClick={() => setShowModal(false)} className="px-4 py-2 text-sm border border-gray-300 rounded-md">
                  Batal
                </button>
                <button onClick={handleAddDivision} className="px-4 py-2 text-sm bg-blue-600 text-white rounded-md">
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal Tempatkan */}
      <TempatkanModal isOpen={isTempatkanModalOpen} onClose={() => setIsTempatkanModalOpen(false)} onSimpan={handleSimpanTempatkan} data={selectedItem} />

      {/* Modal Detail Divisi */}
      <Detaildivisi isOpen={isDetaildivisiOpen} onClose={() => setIsDetaildivisiOpen(false)} onSimpan={handleSimpanDivisi} data={selectedItem} />

      {/* WebDevModal - Detail Divisi when clicking on background image */}
      <WebDevModal isOpen={isWebDevModalOpen} onClose={() => setIsWebDevModalOpen(false)} data={selectedItem} />
    </Card>
  );
}
