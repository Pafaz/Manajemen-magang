import React from "react";
import Calendar from "../../components/Calendar";
import GreetingsBox from "../../components/cards/GreetingsBox";
import AssignmentsTable from "../../components/cards/AssignmentsTable";
import RecommendedSection from "../../components/cards/RecommendedSection";
import ActivityChart from "../../components/charts/ActivityChart";
import EventsSection from "../../components/cards/EventSection";
import Card from "../../components/cards/Card";
import Title from "../../components/Title";

const MentorDashboard = () => {

  return (
    <div className="w-full">
      <div className="flex w-full gap-5">
        {/* Konten Kiri */}
        <div className="flex-[8] w-full flex flex-col gap-5">
          <GreetingsBox />
          <AssignmentsTable />
          <RecommendedSection />
        </div>

        {/* Kalender + Events Section di Kanan */}
        <div className="flex-[3] flex flex-col gap-5">
          <Card className="px-4 py-4">
            <Calendar />
            <EventsSection />
          </Card>

          <Card className="px-0 py-2 mb-3">
            <div className="border-b border-slate-400/[0.5] py-3">
              <Title className="ml-5 text-xl font-semibold">Most Activity</Title>
            </div>
            <ActivityChart />
          </Card>
        </div>
      </div>
    </div>
  );
};

export default MentorDashboard;
