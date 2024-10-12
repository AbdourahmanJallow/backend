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
                    alt={doctor.user.name}
                    className="object-cover rounded-t-md w-full h-full"
                />
            </div>
            <p className="text-slate-700 font-semibold text-[21px] whitespace-normal ">
                {doctor.user.name}
            </p>
            <div className="">
                <p className="text-slate-600 text-lg whitespace-normal">
                    {doctor.specialization}
                </p>
                <p className="text-slate-400 text-[15px] whitespace-normal">
                    Experience: {doctor.yearsOfExperience} year(s)
                </p>
            </div>
            <button
                onClick={handleBookAppointment}
                className="w-full bg-slate-300 hover:bg-slate-400 rounded-xl p-1.5 text-slate-500 hover:text-white mt-2"
            >
                View Doctor
            </button>
        </div>
    );
}

export default DoctorCard;
