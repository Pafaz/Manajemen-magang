import { useState } from 'react';
import { Trash2, Edit, ChevronDown, X } from 'lucide-react';
// Import your existing delete modal component
import ModalDeleteAdminCabang from '../modal/ModalDeleteAdminCabang';

export default function UniversityCardGrid() {
  const [universities, setUniversities] = useState([
    // Universitas category
    { id: 1, name: 'MIT', location: 'Amerika Serikat', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-27', category: 'Universitas' },
    { id: 2, name: 'Harvard University', location: 'Amerika Serikat', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-25', category: 'Universitas' },
    { id: 3, name: 'Oxford University', location: 'Inggris', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia..', createdAt: '2025-04-20', category: 'Universitas' },
    { id: 4, name: 'Stanford University', location: 'Amerika Serikat', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-15', category: 'Universitas' },
    { id: 5, name: 'Universitas Indonesia', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-12', category: 'Universitas' },
    
    // SMK category
    { id: 6, name: 'SMK Negeri 1 Jakarta', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia..', createdAt: '2025-04-22', category: 'SMK' },
    { id: 7, name: 'SMK Telkom Purwokerto', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-18', category: 'SMK' },
    { id: 8, name: 'SMK Negeri 2 Surabaya', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-05', category: 'SMK' },
    { id: 9, name: 'SMK Pariwisata Bandung', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-10', category: 'SMK' },
    
    // Politeknik category
    { id: 10, name: 'Politeknik Negeri Jakarta', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-16', category: 'Politeknik' },
    { id: 11, name: 'Politeknik Elektronik Surabaya', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-08', category: 'Politeknik' },
    { id: 12, name: 'Politeknik Bandung', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-26', category: 'Politeknik' },
    { id: 13, name: 'Politeknik Kesehatan Yogyakarta', location: 'Indonesia', description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.', createdAt: '2025-04-14', category: 'Politeknik' },
  ]);
  
  // State for category dropdown
  const [showCategoryDropdown, setShowCategoryDropdown] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState('All');
  
  // State for add modal
  const [showModal, setShowModal] = useState(false);
  const [newPartner, setNewPartner] = useState({
    name: '',
    location: '',
    description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.',
    website: '',
    category: 'Universitas'
  });
  
  // State for delete modal
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [universityToDelete, setUniversityToDelete] = useState(null);
  
  // Available categories
  const categories = ['All', 'Universitas', 'SMK', 'Politeknik'];
  const addCategories = ['Universitas', 'Sekolah', 'Politeknik'];

  const recentUniversities = [...universities].sort((a, b) => 
    new Date(b.createdAt) - new Date(a.createdAt)
  ).slice(0, 4); // Show only 4 most recent for "Mitra Terbaru"

  // Filter universities by selected category
  const filteredUniversities = selectedCategory === 'All' 
    ? universities 
    : universities.filter(uni => uni.category === selectedCategory);

  // Handle form input changes
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setNewPartner(prev => ({
      ...prev,
      [name]: value
    }));
  };

  // Handle category selection in the form
  const handleCategoryChange = (category) => {
    setNewPartner(prev => ({
      ...prev,
      category
    }));
  };

  // Handle form submission
  const handleSubmit = (e) => {
    e.preventDefault();
    
    const today = new Date().toISOString().split('T')[0];
    const newId = Math.max(...universities.map(uni => uni.id)) + 1;
    
    const partnerToAdd = {
      ...newPartner,
      id: newId,
      createdAt: today
    };
    
    setUniversities(prev => [partnerToAdd, ...prev]);
    setShowModal(false);
    
    // Reset form
    setNewPartner({
      name: '',
      location: '',
      description: 'Tempat para pemimpin masa depan tumbuh, belajar, dan berkontribusi untuk dunia.',
      website: '',
      category: 'Universitas'
    });
  };

  // Handle delete confirmation
  const handleDeleteUniversity = () => {
    if (universityToDelete) {
      setUniversities(prev => prev.filter(uni => uni.id !== universityToDelete.id));
      setShowDeleteModal(false);
      setUniversityToDelete(null);
    }
  };

  // Open delete modal with university to delete
  const openDeleteModal = (university) => {
    setUniversityToDelete(university);
    setShowDeleteModal(true);
  };

  const UniversityCard = ({ university }) => (
    <div className="bg-white rounded-lg border border-gray-200 overflow-hidden w-full flex flex-col h-full">
      <div className="relative">
        <img 
          src="/assets/img/Cover Mitra.png" 
          alt="University Building" 
          className="w-full h-32 object-cover"
        />
        <div className="absolute -bottom-6 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-purple-500 border-2 border-white flex items-center justify-center">
          <img 
            src="/assets/img/post2.png" 
            alt="University Logo" 
            className="w-10 h-10 object-cover rounded-full"
          />
        </div>
      </div>

      <div className="pt-8 px-3 text-center flex-grow">
        <h3 className="font-bold text-base mb-2">{university.name}</h3>
        <p className="text-gray-500 text-xs mb-2">{university.location}</p>
        <p className="text-xs text-gray-700 mb-4 line-clamp-3">{university.description}</p>
      </div>
      
      {/* Fixed bottom buttons */}
      <div className="mt-auto flex border-t border-gray-200">
        <button 
          className="flex-1 py-2 flex items-center justify-center text-gray-500 text-xs hover:bg-gray-50"
          onClick={() => openDeleteModal(university)}
        >
          <Trash2 size={14} className="mr-1" />
          <span>Hapus</span>
        </button>
        <div className="w-px bg-gray-200" />
        <button className="flex-1 py-2 flex items-center justify-center text-yellow-500 text-xs hover:bg-gray-50">
          <Edit size={14} className="mr-1" />
          <span>Edit</span>
        </button>
      </div>
    </div>
  );

  // Add Partner Modal Component
  const AddPartnerModal = () => {
    if (!showModal) return null;
    
    return (
      <div className="fixed inset-0 bg-black/40 flex justify-center items-center z-[999]">
        <div className="bg-white rounded-lg w-full max-w-md">
          <div className="flex justify-between items-center p-4 border-b border-gray-200">
            <h2 className="text-lg font-bold text-gray-800">Tambahkan Mitra Baru</h2>
            <button 
              onClick={() => setShowModal(false)}
              className="text-gray-500 hover:text-gray-700"
            >
              <X size={20} />
            </button>
          </div>
          
          <form onSubmit={handleSubmit} className="p-4">
            <div className="mb-4">
              <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">
                Nama Mitra
              </label>
              <input
                type="text"
                id="name"
                name="name"
                value={newPartner.name}
                onChange={handleInputChange}
                placeholder="Masukkan nama mitra"
                className="w-full p-2 border border-gray-300 rounded-md text-sm"
                required
              />
            </div>
            
            <div className="mb-4">
              <label htmlFor="location" className="block text-sm font-medium text-gray-700 mb-1">
                Alamat
              </label>
              <input
                type="text"
                id="location"
                name="location"
                value={newPartner.location}
                onChange={handleInputChange}
                placeholder="Masukkan alamat disini"
                className="w-full p-2 border border-gray-300 rounded-md text-sm"
                required
              />
            </div>
            
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Foto Lembaga
              </label>
              <div className="flex">
                <button
                  type="button"
                  className="bg-white px-3 py-2 border border-gray-300 rounded-l-md text-sm text-blue-500"
                >
                  Choose File
                </button>
                <span className="flex-1 px-3 py-2 bg-gray-50 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500">
                  No File Chosen
                </span>
              </div>
            </div>
            
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Foto Header
              </label>
              <div className="flex">
                <button
                  type="button"
                  className="bg-white px-3 py-2 border border-gray-300 rounded-l-md text-sm text-blue-500"
                >
                  Choose File
                </button>
                <span className="flex-1 px-3 py-2 bg-gray-50 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-500">
                  No File Chosen
                </span>
              </div>
            </div>
            
            <div className="mb-4">
              <label htmlFor="website" className="block text-sm font-medium text-gray-700 mb-1">
                Website institusi (opsional)
              </label>
              <input
                type="url"
                id="website"
                name="website"
                value={newPartner.website}
                onChange={handleInputChange}
                placeholder="Masukkan link disini"
                className="w-full p-2 border border-gray-300 rounded-md text-sm"
              />
            </div>
            
            <div className="mb-6">
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Jenis Institusi
              </label>
              <div className="flex space-x-4">
                {addCategories.map(category => (
                  <label key={category} className="inline-flex items-center">
                    <input
                      type="radio"
                      className="form-radio text-blue-500"
                      checked={newPartner.category === category}
                      onChange={() => handleCategoryChange(category)}
                    />
                    <span className="ml-2 text-sm">{category}</span>
                  </label>
                ))}
              </div>
            </div>
            
            <div className="flex justify-end space-x-2">
              <button
                type="button"
                onClick={() => setShowModal(false)}
                className="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700"
              >
                Batal
              </button>
              <button
                type="submit"
                className="px-4 py-2 bg-blue-500 border border-blue-500 rounded-md text-sm text-white"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    );
  };

  return (
    <div className="p-2 min-h-screen">
      <div className="max-w-9xl mx-auto space-y-6">
        {/* Mitra Terbaru */}
        <div className="bg-white p-4 rounded-lg shadow-md">
          <div className="flex justify-between items-center mb-3">
            <h2 className="text-lg font-bold text-black-800">Mitra Terbaru</h2>
            <button 
              className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center"
              onClick={() => setShowModal(true)}
            >
              <span className="mr-1">+</span> Tambah Mitra
            </button>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            {recentUniversities.map((university) => (
              <UniversityCard key={university.id} university={university} />
            ))}
          </div>
        </div>

        {/* Mitra Terdaftar */}
        <div className="bg-white p-4 rounded-lg shadow-md">
          <div className="flex justify-between items-center mb-3">
            <h2 className="text-lg font-bold text-black-800">Mitra Terdaftar</h2>
            <div className="flex items-center space-x-2">
              {/* Category dropdown */}
              <div className="relative">
                <button 
                  className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 flex items-center"
                  onClick={() => setShowCategoryDropdown(!showCategoryDropdown)}
                >
                  <span>Category: {selectedCategory}</span>
                  <ChevronDown size={14} className="ml-1" />
                </button>
                
                {/* Dropdown menu */}
                {showCategoryDropdown && (
                  <div className="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                    <ul className="py-1">
                      {categories.map((category) => (
                        <li 
                          key={category} 
                          className="px-3 py-1 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer"
                          onClick={() => {
                            setSelectedCategory(category);
                            setShowCategoryDropdown(false);
                          }}
                        >
                          {category}
                        </li>
                      ))}
                    </ul>
                  </div>
                )}
              </div>
              
              {/* Sort by section */}
              <span className="text-xs text-gray-700">Sort by:</span>
              <button className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 flex items-center">
                <span>Popular</span>
              </button>
            </div>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            {filteredUniversities.map((university) => (
              <UniversityCard key={university.id} university={university} />
            ))}
          </div>
        </div>
      </div>
      
      {/* Add Partner Modal */}
      <AddPartnerModal />
      
      {/* Use your existing Delete Modal Component */}
      {showDeleteModal && universityToDelete && (
        <ModalDeleteAdminCabang
          isOpen={showDeleteModal}
          onClose={() => setShowDeleteModal(false)}
          onConfirm={handleDeleteUniversity}

        />
      )}
    </div>
  );
}