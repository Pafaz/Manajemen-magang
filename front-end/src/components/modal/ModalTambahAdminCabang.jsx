import React, { useState } from 'react';

const ModalTambahAdminCabang = ({ isOpen, onClose, onSave }) => {
  const [formData, setFormData] = useState({
    name: '',
    password: '',
    branch: '',
    adminPhoto: null,
    headerPhoto: null,
    email: '',
    phoneNumber: ''
  });

  const [adminPhotoName, setAdminPhotoName] = useState('No File Chosen');
  const [headerPhotoName, setHeaderPhotoName] = useState('No File Chosen');

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleFileChange = (e, fieldName) => {
    const file = e.target.files[0];
    if (file) {
      setFormData({ ...formData, [fieldName]: file });
      if (fieldName === 'adminPhoto') {
        setAdminPhotoName(file.name);
      } else if (fieldName === 'headerPhoto') {
        setHeaderPhotoName(file.name);
      }
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSave(formData);
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 flex items-center justify-center z-50">
      <div className="fixed inset-0 bg-black opacity-50" onClick={onClose}></div>
      <div className="bg-white rounded-lg w-full max-w-md max-h-[90vh] overflow-y-auto relative z-10">
        <div className="sticky top-0 bg-white px-6 py-4 border-b border-gray-200 flex justify-between items-center">
          <h2 className="text-xl font-bold">Tambah Admin</h2>
          <button onClick={onClose} className="text-gray-500 hover:text-gray-700">
            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <form onSubmit={handleSubmit} className="px-6 py-4">
          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Masukkan Nama</label>
            <input
              type="text"
              name="name"
              value={formData.name}
              onChange={handleChange}
              placeholder="Masukkan Nama Disini"
              className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
              required
            />
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Password</label>
            <input
              type="password"
              name="password"
              value={formData.password}
              onChange={handleChange}
              placeholder="Masukkan Password Disini"
              className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
              required
            />
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Masukkan Cabang Perusahaan</label>
            <div className="relative">
              <select
                name="branch"
                value={formData.branch}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 appearance-none"
                required
              >
                <option value="" disabled>Pilih Cabang Perusahaan</option>
                <option value="Cabang 1">Cabang 1</option>
                <option value="Cabang 2">Cabang 2</option>
                <option value="Cabang 3">Cabang 3</option>
              </select>
              <div className="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                <svg className="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </div>
            </div>
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Foto Admin</label>
            <div className="flex">
              <label className="flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-l-md text-xs text-gray-700 hover:bg-gray-50 cursor-pointer">
                <span>Choose File</span>
                <input
                  type="file"
                  name="adminPhoto"
                  onChange={(e) => handleFileChange(e, 'adminPhoto')}
                  className="hidden"
                  accept="image/*"
                />
              </label>
              <div className="flex-1 px-4 py-2 border border-gray-300 border-l-0 rounded-r-md bg-gray-50 text-gray-500 text-xs">
                {adminPhotoName}
              </div>
            </div>
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Foto Header</label>
            <div className="flex">
              <label className="flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-l-md text-xs text-gray-700 hover:bg-gray-50 cursor-pointer">
                <span>Choose File</span>
                <input
                  type="file"
                  name="headerPhoto"
                  onChange={(e) => handleFileChange(e, 'headerPhoto')}
                  className="hidden"
                  accept="image/*"
                />
              </label>
              <div className="flex-1 px-4 py-2 border border-gray-300 border-l-0 rounded-r-md bg-gray-50 text-gray-500 text-xs">
                {headerPhotoName}
              </div>
            </div>
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Masukkan Email</label>
            <input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              placeholder="Masukkan Email"
              className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
              required
            />
          </div>

          <div className="mb-4">
            <label className="block text-gray-700 text-sm mb-1">Masukkan Nomor HP</label>
            <input
              type="tel"
              name="phoneNumber"
              value={formData.phoneNumber}
              onChange={handleChange}
              placeholder="Masukkan Nomor HP"
              className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
              required
            />
          </div>

          <div className="sticky bottom-0 bg-white py-3 flex justify-end space-x-3 border-t border-gray-200">
            <button
              type="button"
              onClick={onClose}
              className="px-5 py-2 bg-red-400 text-white rounded-md hover:bg-red-500 focus:outline-none"
            >
              Batal
            </button>
            <button
              type="submit"
              className="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none"
            >
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ModalTambahAdminCabang;