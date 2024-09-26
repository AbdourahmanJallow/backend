import { router } from "@inertiajs/react";

function DoctorCard({ doctor }) {
    const handleBookAppointment = () => {
        router.visit(`/doctors/${doctor.id}`); // Navigate to the doctor details page
    };

    return (
        <div className="bg-neutral-100 rounded-md flex flex-col ">
            <div className="relative h-72 mb-3 shadow-sm">
                <img
                    src="https://hips.hearstapps.com/hmg-prod/images/portrait-of-a-happy-young-doctor-in-his-clinic-royalty-free-image-1661432441.jpg"
                    alt={doctor.name}
                    className="object-cover rounded-t-md w-full h-full"
                />
            </div>
            <p className="text-slate-700 font-semibold text-[21px] whitespace-normal ">
                {doctor.name}
            </p>
            <div className="flex justify-between items-center">
                <p className="text-slate-600 text-lg whitespace-normal">
                    {doctor.specialization}
                </p>
                <p className="text-slate-400 text-[15px] whitespace-normal pt-[2px]">
                    {doctor.yearsOfExperience} years of experience
                </p>
            </div>
            <button
                onClick={handleBookAppointment}
                className="w-full bg-green-500 hover:bg-green-600 rounded-xl p-1.5 text-white mt-2"
            >
                Book Appointment
            </button>
        </div>
    );
}

export default DoctorCard;
