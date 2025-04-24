import { MapPin, Globe, Instagram, Linkedin, Flag, Heart } from 'lucide-react';

export default function CompanyCardGrid() {
  // Sample company data
  const companies = Array(12).fill().map((_, index) => ({
    id: index + 1,
    name: "PT. HUMMA TECHNOLOGY INDONESIA",
    location: "Malang, Jawa Timur",
    propertyCount: "150 Property Mappings",
    isFavorite: false,
    hasSocialMedia: {
      website: true,
      instagram: true,
      linkedin: true,
    },
    image: "/api/placeholder/400/200"
  }));

  return (
    <div className="bg-gray-50 p-4">
      <div className="mb-4 flex items-center justify-between">
        <h2 className="text-lg font-medium">Cabang Perusahaan Terdaftar</h2>
        <div className="flex items-center gap-4">
          <div className="flex items-center text-sm text-gray-500">
            <span>Terbaru</span>
            <span className="mx-2">|</span>
            <span>Sort By</span>
            <span className="mx-2">|</span>
            <span>Terbaru</span>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {companies.map((company) => (
          <div key={company.id} className="bg-white rounded shadow overflow-hidden">
            {/* Company Image */}
            <div className="relative">
              <img 
                src={company.image} 
                alt={company.name} 
                className="w-full h-32 object-cover"
              />
              <div className="absolute bottom-2 left-2 bg-blue-500 text-white rounded-full p-1">
                <MapPin size={16} />
              </div>
            </div>
            
            {/* Company Details */}
            <div className="p-3">
              <h3 className="font-bold text-sm">{company.name}</h3>
              <p className="text-xs text-gray-500 mb-1">{company.location}</p>
              <p className="text-xs text-gray-500 mb-2">{company.propertyCount}</p>
              
              {/* Social Media Icons */}
              <div className="flex items-center gap-1 mb-3">
                <div className="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center bg-gray-100">
                  <Globe size={12} className="text-gray-600" />
                </div>
                <div className="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center bg-gray-100">
                  <Instagram size={12} className="text-gray-600" />
                </div>
                <div className="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center bg-gray-100">
                  <Linkedin size={12} className="text-gray-600" />
                </div>
              </div>
              
              {/* Actions */}
              <div className="flex items-center justify-between">
                <button className="bg-blue-50 hover:bg-blue-100 text-blue-500 text-xs py-1 px-3 rounded border border-blue-200">
                  Lihat Detail
                </button>
                
                <div className="flex items-center gap-2">
                  <div className="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center bg-gray-50">
                    <Flag size={12} className="text-gray-500" />
                  </div>
                  
                  <div className="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center bg-gray-50">
                    <Heart size={12} className="text-gray-500" />
                  </div>
                  
                  <button className="bg-red-500 hover:bg-red-600 text-white text-xs py-1 px-3 rounded">
                    Detail
                  </button>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
      
      {/* Pagination */}
      <div className="mt-6 flex items-center justify-between">
        <button className="bg-white text-gray-700 border border-gray-300 rounded px-4 py-2 text-sm">
          Previous
        </button>
        
        <div className="flex items-center gap-1">
          {[1, 2, 3, 4, 5].map((page) => (
            <button 
              key={page} 
              className={`w-8 h-8 flex items-center justify-center rounded ${
                page === 1 ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 border border-gray-300'
              }`}
            >
              {page}
            </button>
          ))}
        </div>
        
        <button className="bg-blue-500 text-white border border-blue-600 rounded px-4 py-2 text-sm">
          Next
        </button>
      </div>
    </div>
  );
}