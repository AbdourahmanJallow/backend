import { useForm, usePage } from "@inertiajs/react";
import { useEffect } from "react";
import { toast } from "react-hot-toast";

function DoctorDetails() {
    const { doctor, doctorUserObject, flash } = usePage().props;

    const { data, setData, post, errors, reset } = useForm({
        date: new Date().toISOString().slice(0, 10), // Set today's date
        time: new Date().toTimeString().slice(0, 5),
        reasons: "",
        doctor_id: doctor.id,
    });

    const handleChange = (e) => {
        setData({ ...data, [e.target.id]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        try {
            post("/patientsAppointments", data, {
                onSuccess: () => {
                    reset();
                },
                onError: (errors) => {
                    console.log(errors);
                    toast.error("Oops. Appointment Failed!");
                },
            });
            toast.success("Appointment made successfully!");
        } catch (error) {
            console.log(error.message);
            toast.error("Appointment Failed!");
        }
    };

    // useEffect(() => {
    //     if (flash.success) {
    //         toast.success(flash.success);
    //     }
    // }, [flash.success]);

    return (
        <div className="w-full min-h-screen p-6 bg-whit shadow-m rounded-md">
            <div className="container mx-auto">
                {/* Doctor Details Row */}
                <div className="flex flex-col md:flex-row items-start gap-8 h-screen">
                    {/* Doctor Image */}
                    <div className="md:w-1/2 w-full h-full">
                        <img
                            src="https://hips.hearstapps.com/hmg-prod/images/portrait-of-a-happy-young-doctor-in-his-clinic-royalty-free-image-1661432441.jpg"
                            alt={doctor.name}
                            className="w-full h-full object-cover rounded-lg"
                        />
                    </div>

                    {/* Doctor Details */}
                    <div className="md:w-1/2 w-full flex flex-col justify-between">
                        <div>
                            <h1 className="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                                Dr. {doctorUserObject.name}
                            </h1>
                            <p className="text-lg font-semibold text-gray-600">
                                Specialization: {doctor.specialization}
                            </p>
                            <p className="text-lg text-gray-600">
                                {doctor.yearsOfExperience} years of experience
                            </p>
                            <p className="text-base text-gray-700 mt-4">
                                {doctor.bio}
                            </p>
                            <p className="text-base text-gray-700 mt-4">
                                <span className="text-lg font-bold">
                                    Location:
                                </span>{" "}
                                {doctor.clinicalAddress}
                            </p>
                        </div>

                        {/* Appointment form */}
                        <div className="w-full mt-24 mx-auto">
                            <form
                                // action={`/doctors/${doctor.id}/book`}
                                // method="POST"
                                onSubmit={handleSubmit}
                                className="bg-neutral-100 p-6 rounded-lg shadow-lg"
                            >
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Reasons
                                    </label>
                                    <textarea
                                        type="text"
                                        name="reasons"
                                        id="reasons"
                                        rows="6"
                                        value={data.reasons}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Appointment Date
                                    </label>
                                    <input
                                        type="date"
                                        name="date"
                                        id="date"
                                        value={data.date}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>

                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700">
                                        Appointment Time
                                    </label>
                                    <input
                                        type="time"
                                        name="time"
                                        id="time"
                                        value={data.time}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none"
                                    />
                                </div>

                                <button
                                    type="submit"
                                    className="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-3"
                                >
                                    Confirm Appointment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default DoctorDetails;
