import React from "react";
import Header from "./shared/Header";

function AppointmentsGrid({ appointments }) {
    return (
        <div className="mt-24">
            {/* <Header title="Appointments" /> */}
            <div className="overflow-x-auto">
                <table className="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th className="py-2 px-4 border-b text-left">#</th>
                            {/* <th className="py-2 px-4 border-b text-left">
                                Appointment ID
                            </th> */}
                            <th className="py-2 px-4 border-b text-left">
                                Doctor Name
                            </th>
                            <th className="py-2 px-4 border-b text-left">
                                Reason
                            </th>
                            <th className="py-2 px-4 border-b text-left">
                                Date
                            </th>
                            <th className="py-2 px-4 border-b text-left">
                                Status
                            </th>
                            <th className="py-2 px-4 border-b text-left">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {appointments.map((appointment, index) => (
                            <tr
                                key={appointment.id}
                                className="hover:bg-gray-100"
                            >
                                {/* Counter */}
                                <td className="py-2 px-4 border-b">
                                    {index + 1}
                                </td>

                                {/* Appointment ID */}
                                {/* <td className="py-2 px-4 border-b">
                                    {appointment.id}
                                </td> */}

                                {/* Doctor Name */}
                                <td className="py-2 px-4 border-b">
                                    {appointment.doctor.user.name}
                                </td>

                                {/* Reason */}
                                <td className="py-2 px-4 border-b">
                                    {appointment.reasons}
                                </td>

                                {/* Date */}
                                <td className="py-2 px-4 border-b">
                                    {new Date(
                                        appointment.scheduled_at
                                    ).toLocaleString()}
                                </td>

                                {/* Status with dynamic background color */}
                                <td className="py-2 px-4 border-b">
                                    <span
                                        className={`py-1 px-3 rounded-full text-white ${
                                            appointment.status === "pending"
                                                ? "bg-yellow-500"
                                                : appointment.status ===
                                                  "scheduled"
                                                ? "bg-blue-500"
                                                : appointment.status ===
                                                  "completed"
                                                ? "bg-green-500"
                                                : "bg-red-500"
                                        }`}
                                    >
                                        {appointment.status}
                                    </span>
                                </td>

                                {/* Action button */}
                                <td className="py-2 px-4 border-b">
                                    {appointment.status !== "canceled" &&
                                        appointment.status !== "completed" && (
                                            <button
                                                className="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700"
                                                onClick={() =>
                                                    handleCancel(appointment.id)
                                                }
                                            >
                                                Cancel
                                            </button>
                                        )}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default AppointmentsGrid;
