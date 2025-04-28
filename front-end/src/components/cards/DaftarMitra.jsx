import { useState } from 'react';
import { Trash2, Edit, ChevronDown } from 'lucide-react';

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
  
  // Available categories
  const categories = ['All', 'Universitas', 'SMK', 'Politeknik'];

  const recentUniversities = [...universities].sort((a, b) => 
    new Date(b.createdAt) - new Date(a.createdAt)
  ).slice(0, 4); // Show only 4 most recent for "Mitra Terbaru"

  // Filter universities by selected category
  const filteredUniversities = selectedCategory === 'All' 
    ? universities 
    : universities.filter(uni => uni.category === selectedCategory);

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
        <button className="flex-1 py-2 flex items-center justify-center text-gray-500 text-xs hover:bg-gray-50">
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

  return (
    <div className="p-2 min-h-screen">
      <div className="max-w-9xl mx-auto space-y-6">
        {/* Mitra Terbaru */}
        <div className="bg-white p-4 rounded-lg shadow-md">
          <div className="flex justify-between items-center mb-3">
            <h2 className="text-lg font-bold text-black-800">Mitra Terbaru</h2>
            <button className="bg-white px-2 py-1 rounded-md text-xs border border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center">
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
    </div>
  );
}