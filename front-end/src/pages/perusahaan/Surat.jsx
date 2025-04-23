import { useState } from "react";
import DataSurat from "../../components/cards/DataSurat";
import PerusahaanCard from "../../components/cards/PerusahaanCard";
import Card from "../../components/cards/Card"; // Import the new component

const Approval = () => {
  return (
    <div className="p-6">
      {/* Use the new PerusahaanCard component */}
      <PerusahaanCard />

      {/* Komponen DataApproval */}
      <Card className="mt-8 px-1 pb-6">
        <DataSurat />
      </Card>
    </div>
  );
};

export default Approval;