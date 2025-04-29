import React, { useEffect, useState } from "react";

const ModalTambahMentor = ({
  isOpen,
  onClose,
  onSave,
  mode = "add",
  mentorData = null,
}) => {
  const [formData, setFormData] = useState({
    email: "",
    name: "",
    mentorPhoto: null,
    headerPhoto: null,
    branch: "",
    division: "",
  });

  // Reset form when modal opens
  useEffect(() => {
    if (isOpen) {
      if (mode === "edit" && mentorData) {
        setFormData({
          email: mentorData.email || "",
          name: mentorData.name || "",
          mentorPhoto: null,
          headerPhoto: null,
          branch: mentorData.branch || "",
          division: mentorData.division || "",
        });
      } else {
        setFormData({
          email: "",
          name: "",
          mentorPhoto: null,
          headerPhoto: null,
          branch: "",
          division: "",
        });
      }
    }
  }, [isOpen, mode, mentorData]);

  // Close modal when Escape key is pressed
  useEffect(() => {
    const handleEsc = (event) => {
      if (event.key === "Escape") {
        onClose();
      }
    };

    if (isOpen) {
      document.addEventListener("keydown", handleEsc);
    }

    return () => {
      document.removeEventListener("keydown", handleEsc);
    };
  }, [isOpen, onClose]);

  // Prevent page scrolling when modal is open
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "unset";
    }

    return () => {
      document.body.style.overflow = "unset";
    };
  }, [isOpen]);

  if (!isOpen) return null;

  // Close modal when clicking on backdrop
  const handleBackdropClick = (e) => {
    if (e.target === e.currentTarget) {
      onClose();
    }
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };

  const handleFileChange = (e) => {
    const { name, files } = e.target;
    setFormData({
      ...formData,
      [name]: files[0],
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSave(formData);
  };

  const handleCancel = () => {
    onClose();
  };

  return (
    <div
      className="fixed inset-0 bg-black/40 flex justify-center items-center z-[999]"
      onClick={handleBackdropClick}
    >
      <div className="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden">
        {/* Modal Header */}
        <div className="border-b px-6 py-4 flex justify-between items-center">
          <h3 className="font-bold text-lg text-blue-800">
            {mode === "edit" ? "Edit Mentor" : "Tambah Mentor"}
          </h3>

          <button
            onClick={onClose}
            className="text-gray-400 hover:text-gray-600"
          >
            <svg
              className="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        {/* Modal Body - Form */}
        <div className="px-6 py-4">
          <form onSubmit={handleSubmit}>
            {/* Email Input */}
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Masukkan Email
              </label>
              <input
                type="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
                placeholder="Masukkan Email"
                required
              />
            </div>

            {/* Name Input */}
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Masukkan Nama
              </label>
              <input
                type="text"
                name="name"
                value={formData.name}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
                placeholder="Masukkan Nama Disini"
                required
              />
            </div>

            {/* Mentor Photo Upload */}
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Foto Mentor
              </label>
              <div className="flex">
                <label className="flex-shrink-0 cursor-pointer px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                  Choose File
                  <input
                    type="file"
                    name="mentorPhoto"
                    onChange={handleFileChange}
                    className="hidden"
                    accept="image/*"
                  />
                </label>
                <span className="flex-grow px-3 py-2 border border-gray-300 border-l-0 rounded-r-md bg-white">
                  {formData.mentorPhoto
                    ? formData.mentorPhoto.name
                    : "No File Chosen"}
                </span>
              </div>
            </div>

            {/* Header Photo Upload */}
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Foto Header
              </label>
              <div className="flex">
                <label className="flex-shrink-0 cursor-pointer px-3 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                  Choose File
                  <input
                    type="file"
                    name="headerPhoto"
                    onChange={handleFileChange}
                    className="hidden"
                    accept="image/*"
                  />
                </label>
                <span className="flex-grow px-3 py-2 border border-gray-300 border-l-0 rounded-r-md bg-white">
                  {formData.headerPhoto
                    ? formData.headerPhoto.name
                    : "No File Chosen"}
                </span>
              </div>
            </div>

            {/* Branch Select */}
            <div className="mb-4">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Masukkan Cabang Perusahaan
              </label>
              <select
                name="branch"
                value={formData.branch}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              >
                <option value="" disabled>
                  Pilih Cabang Perusahaan
                </option>
                <option value="cabang-a">Cabang A</option>
                <option value="cabang-b">Cabang B</option>
                <option value="cabang-c">Cabang C</option>
              </select>
            </div>

            {/* Division Select */}
            <div className="mb-6">
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Masukkan Divisi
              </label>
              <select
                name="division"
                value={formData.division}
                onChange={handleChange}
                className="w-full px-3 py-2 border border-gray-300 rounded-md"
                required
              >
                <option value="" disabled>
                  Pilih Divisi
                </option>
                <option value="UI/UX">UI/UX</option>
                <option value="Web Developer">Web Developer</option>
                <option value="Mobile">Mobile</option>
                <option value="Digital Marketing">Digital Marketing</option>
              </select>
            </div>

            {/* Action Buttons */}
            <div className="flex justify-end space-x-2">
              <button
                type="button"
                onClick={handleCancel}
                className="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
              >
                Batal
              </button>
              <button
                type="submit"
                className="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default ModalTambahMentor;
