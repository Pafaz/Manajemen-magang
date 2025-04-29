import { useState, useRef } from 'react';

export default function DataUmumPerusahaan() {
  // State for document files
  const [documents, setDocuments] = useState({
    legalitas: {
      file: null,
      name: 'Bukti Legalitas Perusahaan',
      size: '23 kb',
      date: '25 Jun 2025',
      previewUrl: '/assets/img/Cover.png'
    },
    npwp: {
      file: null,
      name: 'Bukti NPWP Perusahaan',
      size: '25 kb',
      date: '25 Jun 2025',
      previewUrl: '/assets/img/Cover.png'
    },
    profile: {
      file: null,
      name: 'Cover',
      size: '25 kb',
      date: '25 Jun 2025',
      previewUrl: '/assets/img/Cover.png'
    }
  });

  // State for modal
  const [showModal, setShowModal] = useState(false);

  // Refs for file inputs
  const legalitasInputRef = useRef(null);
  const npwpInputRef = useRef(null);
  const profileInputRef = useRef(null);

  // Function to handle file upload
  const handleFileUpload = (docType, e) => {
    const file = e.target.files[0];
    if (file) {
      const fileSize = (file.size / 1024).toFixed(0) + ' kb';
      const dateAdded = new Date().toLocaleDateString('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
      });
      
      // Create a preview URL
      const previewUrl = URL.createObjectURL(file);
      
      // Update document state
      setDocuments(prev => ({
        ...prev,
        [docType]: {
          ...prev[docType],
          file: file,
          name: file.name,
          size: fileSize,
          date: dateAdded,
          previewUrl: previewUrl
        }
      }));
    }
  };

  // Function to handle document preview
  const handlePreview = (docType) => {
    const doc = documents[docType];
    if (doc.file) {
      // If a new file has been uploaded, use its preview URL
      window.open(doc.previewUrl, '_blank');
    } else {
      // For demo purposes, open the default image
      window.open(doc.previewUrl, '_blank');
    }
  };

  // Function to handle document download
  const handleDownload = (docType) => {
    const doc = documents[docType];
    
    if (doc.file) {
      // If a new file has been uploaded, create download link for it
      const downloadUrl = URL.createObjectURL(doc.file);
      const a = document.createElement('a');
      a.href = downloadUrl;
      a.download = doc.name;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(downloadUrl);
    } else {
      // For demo purposes, download the default image
      fetch(doc.previewUrl)
        .then(response => response.blob())
        .then(blob => {
          const downloadUrl = URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = downloadUrl;
          a.download = doc.name + '.png'; // Default extension for demo image
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
          URL.revokeObjectURL(downloadUrl);
        });
    }
  };

  // Function to trigger file input click
  const triggerFileInput = (inputRef) => {
    inputRef.current.click();
  };

  // Function to handle edit action
  const handleEdit = () => {
    setShowModal(true);
    
    // Automatically close the modal after 3 seconds
    setTimeout(() => {
      setShowModal(false);
    }, 3000);
  };

  return (
    <div className="bg-white rounded-lg shadow p-6 max-w-8xl mx-auto relative">
      {/* Header */}
      <div className="mb-5">
        <h2 className="text-lg font-bold text-gray-800 mb-1">Data Umum Perusahaan</h2>
        <p className="text-sm text-gray-600">Silahkan Lengkapi Data Terlebih Dahulu!</p>
        <div className="mt-4 border-b border-gray-300"></div> {/* Ini garisnya */}
      </div>
      
      {/* Company Representative Data */}
      <div className="mb-7 ">
        <h2 className="text-lg font-bold text-black-800 mb-5">Data Umum Perusahaan</h2>
        <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
          <div>
            <label className="block text-sm font-bold text-black mb-1">Nama Penanggung Jawab</label>
            <input
            type="text"
            placeholder="Jiro S.Kom., M.Kom"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>     
          <div>
          <label className="block text-sm font-bold text-black mb-1">Nomor HP Penanggung Jawab</label>
            <input
            type="text"
            placeholder="123456789"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          
          <div>
          <label className="block text-sm font-bold text-black mb-1">Jabatan Penanggung Jawab</label>
            <input
            type="text"
            placeholder="HRD"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          
          <div>
          <label className="block text-sm font-bold text-black mb-1">Email Penanggung Jawab</label>
            <input
            type="text"
            placeholder="jiroo@gmail.com"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
          <label className="block text-sm font-bold text-black mb-1">Nama Perusahaan</label>
            <input
            type="text"
            placeholder="PT HUMMA TEKNOLOGI INDONESIA"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          
          <div>
          <label className="block text-sm font-bold text-black mb-1">Tanggal Berdiri</label>
            <input
            type="text"
            placeholder="12 MARET 2018"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          
          <div>
          <label className="block text-sm font-bold text-black mb-1">Bidang Usaha</label>
            <input
            type="text"
            placeholder="Teknologi Informasi"
            className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
        </div>
      </div>
      
      {/* Company Description */}
      <div className="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <label className="block text-sm font-bold text-black mb-1 col-span-4">Deskripsi Perusahaan</label>
        <textarea
          placeholder="PT. Humma Technology Indonesia adalah perusahaan yang bergerak di bidang teknologi informasi dengan fokus pada pengembangan solusi digital inovatif untuk mendukung transformasi bisnis di era industri 4.0. Kami menyediakan layanan pengembangan perangkat lunak, sistem informasi, dan integrasi teknologi berbasis cloud untuk berbagai sektor industri."
          className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500 col-span-3 md:col-span-3"
          rows="5"
        />
      </div>
      
      {/* Contact Information */}
      <div className="mb-6">
        <h2 className="text-lg font-bold text-black-800 mb-5">Kontak Perusahaan</h2>
        
        <div className="flex mb-4 space-x-4">
          <div className="flex-1">
            <label className="block text-sm font-bold text-black mb-1">Alamat Perusahaan</label>
            <textarea
              placeholder="Perum Permata Regency 1, Blk. 10 No.28, Perun Gpa, Ngijo, Kec. Karang Ploso, Kabupaten Malang, Jawa Timur 65152"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500 resize-none"
              rows="2"
            />
          </div>
          <div className="w-auto">
            <label className="block text-sm font-bold text-black mb-1">Provinsi</label>
            <input
              type="text"
              placeholder="Jawa Timur"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          <div className="w-auto">
            <label className="block text-sm font-bold text-black mb-1">Kabupaten/Kota</label>
            <input
              type="text"
              placeholder="Malang"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
          <div className="w-auto">
            <label className="block text-sm font-bold text-black mb-1">Kode Pos</label>
            <input
              type="text"
              placeholder="12345"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
        </div>

        <div className="flex mb-4 space-x-4">
          <div className="w-1/4">
            <label className="block text-sm font-bold text-black mb-1">Email Perusahaan</label>
            <input
              type="text"
              placeholder="ini@gmail.com"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>

          <div className="w-1/4">
            <label className="block text-sm font-bold text-black mb-1">Nomor Telepon Perusahaan</label>
            <input
              type="text"
              placeholder="12345889"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>

          <div className="w-1/3">
            <label className="block text-sm font-bold text-black mb-1">Website Perusahaan</label>
            <input
              type="text"
              placeholder="www.hummatech.co.id"
              className="w-full p-2 border border-[#D5DBE7] rounded placeholder-[#667797] focus:outline-none focus:ring-1 focus:ring-blue-500"
            />
          </div>
        </div>
      </div>

      {/* Supporting Documents */}
      <div className="mb-16">
        <h3 className="text-md font-semibold text-gray-800 mb-4">Dokumen Pendukung</h3>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {/* Document 1 - Legalitas */}
          <div>
            <h4 className="text-sm font-medium text-black mb-2">Bukti Legalitas Perusahaan</h4>
            <div className="p-3">
              <div className="flex items-center mb-2">
                <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden cursor-pointer" onClick={() => triggerFileInput(legalitasInputRef)}>
                  <img src={documents.legalitas.previewUrl} alt="Document preview" className="w-full h-full object-cover" />
                </div>
                <input 
                  type="file" 
                  ref={legalitasInputRef} 
                  className="hidden" 
                  onChange={(e) => handleFileUpload('legalitas', e)}
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                />
                <div className="flex-1">
                  <p className="font-medium text-xs text-[#667797]">{documents.legalitas.name}</p>
                  <p className="text-xs text-gray-500">Size: {documents.legalitas.size}</p>
                  <p className="text-xs text-gray-500">Date Added: {documents.legalitas.date}</p>
                </div>
                <div className="flex flex-col gap-2 items-end ml-3">
                  <button 
                    className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handleDownload('legalitas')}
                  >
                    <i className="bi bi-download"></i> Download
                  </button>
                  <button 
                    className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handlePreview('legalitas')}
                  >
                    <i className="bi bi-eye"></i> Preview
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          {/* Document 2 - NPWP */}
          <div>
            <h4 className="text-sm font-medium text-black">Bukti NPWP Perusahaan</h4>
            <div className="p-3">
              <div className="flex items-center mb-2">
                <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden cursor-pointer" onClick={() => triggerFileInput(npwpInputRef)}>
                  <img src={documents.npwp.previewUrl} alt="Document preview" className="w-full h-full object-cover" />
                </div>
                <input 
                  type="file" 
                  ref={npwpInputRef} 
                  className="hidden" 
                  onChange={(e) => handleFileUpload('npwp', e)}
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                />
                <div className="flex-1">
                  <p className="font-medium text-xs text-[#667797]">{documents.npwp.name}</p>
                  <p className="text-xs text-gray-500">Size: {documents.npwp.size}</p>
                  <p className="text-xs text-gray-500">Date Added: {documents.npwp.date}</p>
                </div>
                <div className="flex flex-col gap-2 items-end ml-3">
                  <button 
                    className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handleDownload('npwp')}
                  >
                    <i className="bi bi-download"></i> Download
                  </button>
                  <button 
                    className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handlePreview('npwp')}
                  >
                    <i className="bi bi-eye"></i> Preview
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          {/* Document 3 - Profile */}
          <div>
            <h4 className="text-sm font-medium text-black">Profil Perusahaan Background</h4>
            <div className="p-3">
              <div className="flex items-center mb-2">
                <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden cursor-pointer" onClick={() => triggerFileInput(profileInputRef)}>
                  <img src={documents.profile.previewUrl} alt="Document preview" className="w-full h-full object-cover" />
                </div>
                <input 
                  type="file" 
                  ref={profileInputRef} 
                  className="hidden" 
                  onChange={(e) => handleFileUpload('profile', e)}
                  accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                />
                <div className="flex-1">
                  <p className="font-medium text-xs text-[#667797]">{documents.profile.name}</p>
                  <p className="text-xs text-gray-500">Size: {documents.profile.size}</p>
                  <p className="text-xs text-gray-500">Date Added: {documents.profile.date}</p>
                </div>
                <div className="flex flex-col gap-2 items-end ml-3">
                  <button 
                    className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handleDownload('profile')}
                  >
                    <i className="bi bi-download"></i> Download
                  </button>
                  <button 
                    className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2"
                    onClick={() => handlePreview('profile')}
                  >
                    <i className="bi bi-eye"></i> Preview
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}