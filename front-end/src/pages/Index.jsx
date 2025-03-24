import AboutSection from "../components/section/AboutSection";
import CarierStart from "../components/section/CarierStart";
import Gallery from "../components/section/Gallery";
import HeroSection from "../components/section/HeroSection";
import InternshipDivisions from "../components/section/InternshipDivisions";
import InternshipLanding from "../components/section/InternshipLanding";
import MyPartner from "../components/section/MyPartner";
import StatsSection from "../components/section/StatsSection";
import Testimonials from "../components/section/Testimonials";

const Index = () => {
  return <>
    <HeroSection/>
    <AboutSection/>
    <InternshipDivisions/>
    <StatsSection/>
    <InternshipLanding/>
    <Gallery/>
    <CarierStart/>
    <MyPartner/>
    <Testimonials/>
  </>;
};

export default Index;
