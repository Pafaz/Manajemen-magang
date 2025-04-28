import { useState } from 'react';

export default function DataUmumPerusahaan() {
  return (
    <div className="bg-white rounded-lg shadow p-6 max-w-8xl mx-auto">
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
<div className="mb-6">
  <h3 className="text-md font-semibold text-gray-800 mb-4">Dokumen Pendukung</h3>
  
  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
    {/* Document 1 */}
    <div>
      <h4 className="text-sm font-medium text-[#667797] mb-2">Bukti Legalitas Perusahaan</h4>
      <div className="p-3">
        <div className="flex items-center mb-2">
          <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
            <img src="/assets/img/Cover.png" alt="Document preview" className="w-full h-full object-cover" />
          </div>
          <div className="flex-1">
            <p className="font-medium text-xs text-[#667797]">Bukti Legalitas Perusahaan</p>
            <p className="text-xs text-gray-500">Size: 23 kb</p>
            <p className="text-xs text-gray-500">Date Added: 25 Jun 2025</p>
          </div>
          <div className="flex flex-col gap-2 items-end ml-3">
            <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
              <i className="bi bi-download"></i> Download
            </button>
            <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
              <i className="bi bi-eye"></i> Preview
            </button>
          </div>
        </div>
      </div>
    </div>
    
    {/* Document 2 */}
    <div>
      <h4 className="text-sm font-medium text-black">Bukti NPWP Perusahaan</h4>
      <div className="p-3">
        <div className="flex items-center mb-2">
          <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
            <img src="/assets/img/Cover.png" alt="Document preview" className="w-full h-full object-cover" />
          </div>
          <div className="flex-1">
            <p className="font-medium text-xs text-[#667797]">Bukti NPWP Perusahaan</p>
            <p className="text-xs text-gray-500">Size: 25 kb</p>
            <p className="text-xs text-gray-500">Date Added: 25 Jun 2025</p>
          </div>
          <div className="flex flex-col gap-2 items-end ml-3">
            <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
              <i className="bi bi-download"></i> Download
            </button>
            <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
              <i className="bi bi-eye"></i> Preview
            </button>
          </div>
        </div>
      </div>
    </div>
    
    {/* Document 3 */}
    <div>
      <h4 className="text-sm font-medium text-black ">Profil Perusahaan Background</h4>
      <div className="p-3">
        <div className="flex items-center mb-2">
          <div className="h-16 w-16 mr-3 bg-gray-200 rounded overflow-hidden">
            <img src="/assets/img/Cover.png" alt="Document preview" className="w-full h-full object-cover" />
          </div>
          <div className="flex-1">
            <p className="font-medium text-xs text-[#667797]">Cover</p>
            <p className="text-xs text-gray-500">Size: 25 kb</p>
            <p className="text-xs text-gray-500">Date Added: 25 Jun 2025</p>
          </div>
          <div className="flex flex-col gap-2 items-end ml-3">
            <button className="bg-blue-600 text-white text-xs rounded py-1 px-3 flex items-center gap-2">
              <i className="bi bi-download"></i> Download
            </button>
            <button className="border border-gray-300 text-gray-600 text-xs rounded py-1 px-3 flex items-center gap-2">
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