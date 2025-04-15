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
import Gallery from "./src/pages/Gallery";
import Procedure from "./src/pages/Procedure";
import Contact from "./src/pages/Contact";
import Absensi from "./src/pages/student/Absensi";
import Jurnal from "./src/pages/student/Jurnal";


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
    path: "/auth/register",
    element: <Register />,
  },
  {
    path: "/student",
    element: <StudentLayout />,
    children: [
      {
        path: "dashboard",
        element: <Dashboard />,
      },
      {
        path:"absensi",
        element:<Absensi/>
      },
      {
        path:"jurnal",
        element:<Jurnal/>
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
      }
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
    ],
  },
  {
    path: "/auth/login",
    element: <Login />,
  },
  {
    path: "*",
    element: <NotFound />,
  },
]);
