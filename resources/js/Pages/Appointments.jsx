import { usePage } from "@inertiajs/react";
import Header from "../components/shared/Header";
import AppointmentsGrid from "../components/AppointmentsGrid";
import { useEffect } from "react";
import toast from "react-hot-toast";

function Appointments() {
    const { appointments, flash } = usePage().props;

    // useEffect(() => {
    //     if (flash.success) {
    //         toast.success(flash.success);
    //     }
    // }, [flash.success]);

    return (
        <div>
            <Header title="My Appointments" />
            <AppointmentsGrid appointments={appointments} />
        </div>
    );
}

// Appointments.layout = (page) => <Layout children={page} />;

export default Appointments;
