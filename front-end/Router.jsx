import { createBrowserRouter } from "react-router-dom";
import GuestLayout from "./src/layout/GuestLayout";
import Index from "./src/pages/Index";
import NotFound from "./src/pages/Error/NotFound";
import About from "./src/pages/About";
import Register from "./src/pages/Auth/Register";
import Login from "./src/pages/Auth/Login";
import StudentLayout from "./src/layout/StudentLayout";
import Dashboard from "./src/pages/student/Dashboard";
import MentorLayout from "./src/layout/MentorLayout";
import MentorDashboard from "./src/pages/mentor/MentorDashboard";
import DataSiswa from "./src/pages/mentor/Siswa";
import TrackRecord from "./src/pages/mentor/trackrecord";
import OnlinePresentasi from "./src/pages/mentor/PresentasiOnline";
import AdminDashboard from "./src/pages/admin/AdminDashboard";
import AdminLayout from "./src/layout/AdminLayout";
import Approval from "./src/pages/admin/Appoval";
import PendataanAdmin from "./src/pages/admin/PendataanAdmin";
import PerusahaanLayout from "./src/layout/PerusahaanLayout";
import DashboardPerusahaan from "./src/pages/perusahaan/Dashboard";
import BerandaPerusahaan from "./src/pages/perusahaan/BerandaPerusahaan";
import DetailCabang from "./src/pages/perusahaan/DetailCabang";
import Admin from "./src/pages/perusahaan/Admin";
import Mentor from "./src/pages/perusahaan/Mentor";
import Peserta from "./src/pages/perusahaan/Peserta";
import Divisi from "./src/pages/perusahaan/Divisi";
import ApprovalPerusahaan from "./src/pages/perusahaan/Approval";
import Pendataan from "./src/pages/perusahaan/Pendataan";
import DataAbsensi from "./src/pages/perusahaan/Absensi";
import RFID from "./src/pages/perusahaan/RFID";
import Surat from "./src/pages/perusahaan/Surat";
import KategoriProject from "./src/pages/perusahaan/KategoriProject";
import Gallery from "./src/pages/Gallery";
import Procedure from "./src/pages/Procedure";
import Contact from "./src/pages/Contact";
import Absensi from "./src/pages/student/Absensi";
import Jurnal from "./src/pages/student/Jurnal";
import Presentasi from "./src/pages/student/Presentasi";
import DetailPresentasi from "./src/pages/student/DetailPresentasi";
import RiwayatPresentasi from "./src/pages/student/RiwayatPresentasi";
import SelectAuth from "./src/pages/Auth/SelectAuth";
import GoogleSuccess from "./src/pages/Auth/GoogleSuccess";
import AuthLayout from "./src/layout/AuthLayout";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <GuestLayout />,
    children: [
      {
        path: "/",
        element: <Index />,
      },
      {
        path: "/about_us",
        element: <About />,
      },
      {
        path: "/gallery",
        element: <Gallery />,
      },
      {
        path: "/procedure",
        element: <Procedure />,
      },
      {
        path: "/contact_us",
        element: <Contact />,
      },
    ],
  },
  {
    path: "/siswa",
    element: <StudentLayout />,
    children: [
      {
        path: "dashboard",
        element: <Dashboard />,
      },
      {
        path: "absensi",
        element: <Absensi />,
      },
      {
        path: "jurnal",
        element: <Jurnal />,
      },
      {
        path: "presentasi",
        element: <Presentasi />,
      },
      {
        path: "detail-presentasi",
        element: <DetailPresentasi />,
      },
      {
        path: "riwayat-presentasi",
        element: <RiwayatPresentasi />,
      },
    ],
  },
  {
    path: "/mentor",
    element: <MentorLayout />,
    children: [
      {
        path: "dashboard",
        element: <MentorDashboard />,
      },
      {
        path: "siswa",
        element: <DataSiswa />,
      },
      {
        path: "track",
        element: <TrackRecord />,
      },
      {
        path: "online",
        element: <OnlinePresentasi />,
      },
    ],
  },
  {
    path: "/admin",
    element: <AdminLayout />,
    children: [
      {
        path: "dashboard",
        element: <AdminDashboard />,
      },
      {
        path: "approval",
        element: <Approval />,
      },
      {
        path: "pendataan",
        element: <PendataanAdmin />,
      },
    ],
  },
  {
    path: "/auth",
    element: <AuthLayout />,
    children: [
      {
        path: "register",
        element: <Register />,
      },
      {
        path: "login",
        element: <Login />,
      },
      {
        path: "SelectAuth",
        element: <SelectAuth />,
      },
      {
        path: "google/success",
        element: <GoogleSuccess />,
      },
    ],
  },
  {
    path: "/perusahaan",
    element: <PerusahaanLayout />,
    children: [
      {
        path: "dashboard",
        element: <DashboardPerusahaan />,
      },
      {
        path: "beranda",
        element: <BerandaPerusahaan />,
      },
      {
        path: "admin",
        element: <Admin />,
      },
      {
        path: "mentor",
        element: <Mentor />,
      },
      {
        path: "peserta",
        element: <Peserta />,
      },
      {
        path :"divisi",
        element :<Divisi/>,
      },
      {
        path :"approval",
        element :<ApprovalPerusahaan/>,
      },
      {
        path :"pendataan",
        element :<Pendataan/>,
      },
      {
        path: "absensi",
        element : <DataAbsensi/>,
      },
      {
        path: "surat",
        element : <Surat/>,
      },
      {
        path: "RFID",
        element : <RFID/>,
      },
      {
        path: "kat-projek",
        element : <KategoriProject/>,
      },
    ],
  },
  {
    path: "*",
    element: <NotFound />,
  },
]);
