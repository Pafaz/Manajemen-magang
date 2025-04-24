import React, { useState } from 'react';

export default function CompanyBranchModal({ isOpen, onClose, onSave }) {
  const [formData, setFormData] = useState({
    name: '',
    businessField: '',
    province: '',
    city: '',
    website: '',
    instagram: '',
    linkedin: ''
  });
  
  const [isCustomBusinessField, setIsCustomBusinessField] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    
    if (name === 'businessField' && value === 'lainnya') {
      setIsCustomBusinessField(true);
      setFormData(prevState => ({
        ...prevState,
        businessField: ''
      }));
    } else if (name === 'businessField' && isCustomBusinessField) {
      setIsCustomBusinessField(false);
      setFormData(prevState => ({
        ...prevState,
        [name]: value
      }));
    } else {
      setFormData(prevState => ({
        ...prevState,
        [name]: value
      }));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSave(formData);
    resetForm();
  };

  const resetForm = () => {
    setFormData({
      name: '',
      businessField: '',
      province: '',
      city: '',
      website: '',
      instagram: '',
      linkedin: ''
    });
    setIsCustomBusinessField(false);
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black/40 flex justify-center items-center z-[999]">
      <div className="bg-white rounded-lg shadow-lg w-full max-w-md">
        <div className="p-5">
          <div className="flex justify-between items-center mb-4">
            <h2 className="text-xl font-bold">Tambah Cabang Perusahaan</h2>
            <button 
              onClick={() => {
                resetForm();
                onClose();
              }}
              className="text-gray-500 hover:text-gray-700"
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <form onSubmit={handleSubmit}>
            {/* <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Nama Cabang</label>
              <input 
                type="text" 
                name="name"
                value={formData.name}
                onChange={handleChange}
                placeholder="Masukkan Nama Cabang"
                className="w-full p-2 border border-gray-300 rounded-md"
                required
              />
            </div> */}

            <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Bidang Usaha<span className="text-red-500">*</span></label>
              <div className="relative w-3/4">
                {isCustomBusinessField ? (
                  <input 
                    type="text" 
                    name="businessField"
                    value={formData.businessField}
                    onChange={handleChange}
                    placeholder="Masukkan Bidang Usaha"
                    className="w-full p-2 border border-gray-300 rounded-md"
                    required
                  />
                ) : (
                  <>
                    <select 
                      name="businessField"
                      value={formData.businessField}
                      onChange={handleChange}
                      className="w-full p-2 pr-10 border border-gray-300 rounded-md appearance-none bg-white"
                      required
                    >
                      <option value="" disabled>Pilih Bidang Usaha</option>
                      <option value="teknologi">Teknologi</option>
                      <option value="manufaktur">Manufaktur</option>
                      <option value="jasa">Jasa</option>
                      <option value="perdagangan">Perdagangan</option>
                      <option value="lainnya">Lainnya</option>
                    </select>
                    <div className="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                      <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </>
                )}
              </div>
              {isCustomBusinessField && (
                <div className="mt-2">
                  <button 
                    type="button" 
                    onClick={() => {
                      setIsCustomBusinessField(false);
                      setFormData(prev => ({ ...prev, businessField: '' }));
                    }}
                    className="text-sm text-blue-500 hover:text-blue-700"
                  >
                    Kembali ke Pilihan
                  </button>
                </div>
              )}
            </div>

            <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Provinsi<span className="text-red-500">*</span></label>
              <div className="relative w-3/4">
                <select 
                  name="province"
                  value={formData.province}
                  onChange={handleChange}
                  className="w-full p-2 pr-10 border border-gray-300 rounded-md appearance-none bg-white"
                  required
                >
                  <option value="" disabled>Pilih Provinsi</option>
                  <option value="jawa_timur">Jawa Timur</option>
                  <option value="jawa_barat">Jawa Barat</option>
                  <option value="jawa_tengah">Jawa Tengah</option>
                  <option value="dki_jakarta">DKI Jakarta</option>
                </select>
                <div className="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                  <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div className="mb-5">
              <label className="block text-sm font-medium mb-2">Kota<span className="text-red-500">*</span></label>
              <div className="relative w-3/4">
                <select 
                  name="city"
                  value={formData.city}
                  onChange={handleChange}
                  className="w-full p-2 pr-10 border border-gray-300 rounded-md appearance-none bg-white"
                  required
                >
                  <option value="" disabled>Pilih Kota</option>
                  <option value="malang">Malang</option>
                  <option value="surabaya">Surabaya</option>
                  <option value="bandung">Bandung</option>
                  <option value="jakarta">Jakarta</option>
                </select>
                <div className="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                  <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div className="mb-6">
              <label className="block text-sm font-medium mb-2">Sosial Media Instalasi</label>
              <div className="grid grid-cols-3 gap-3">
                <div className="flex items-center border border-gray-300 rounded-md p-2">
                  <div className="text-blue-500 mr-2">
                    <i className="bi bi-globe w-5 h-5"></i>
                  </div>
                  <input 
                    type="url" 
                    name="website"
                    value={formData.website}
                    onChange={handleChange}
                    placeholder="Website"
                    className="w-full outline-none text-sm bg-transparent"
                  />
                </div>
                
                <div className="flex items-center border border-gray-300 rounded-md p-2">
                  <div className="text-pink-500 mr-2">
                    <i className="bi bi-instagram w-5 h-5"></i>
                  </div>
                  <input 
                    type="text" 
                    name="instagram"
                    value={formData.instagram}
                    onChange={handleChange}
                    placeholder="Instagram"
                    className="w-full outline-none text-sm bg-transparent"
                  />
                </div>
                
                <div className="flex items-center border border-gray-300 rounded-md p-2">
                  <div className="text-blue-700 mr-2">
                    <i className="bi bi-linkedin w-5 h-5"></i>
                  </div>
                  <input 
                    type="text" 
                    name="linkedin"
                    value={formData.linkedin}
                    onChange={handleChange}
                    placeholder="LinkedIn"
                    className="w-full outline-none text-sm bg-transparent"
                  />
                </div>
              </div>
            </div>

            <div className="flex justify-end space-x-2">
              <button
                type="button"
                onClick={() => {
                  resetForm();
                  onClose();
                }}
                className="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
              >
                Batal
              </button>
              <button
                type="submit"
                className="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}