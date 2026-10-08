import React from 'react';

export default function ApplicationLogo({ className = '' }) {
    return (
        <div className={`flex flex-col items-center justify-center ${className}`}>
            {/* Database Isometric Block */}
            <svg
                viewBox="0 0 200 200"
                className="h-28 w-28 object-contain"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                {/* Top Level */}
                <path
                    d="M100 20 L165 55 L100 90 L35 55 Z"
                    fill="none"
                    stroke="#F97316"
                    strokeWidth="10"
                    strokeLinejoin="round"
                />
                
                {/* Middle Level */}
                <path
                    d="M35 75 L100 110 L165 75"
                    fill="none"
                    stroke="#0284C7"
                    strokeWidth="10"
                    strokeLinejoin="round"
                />
                
                {/* Bottom Level */}
                <path
                    d="M35 110 L100 145 L165 110"
                    fill="none"
                    stroke="#F97316"
                    strokeWidth="10"
                    strokeLinejoin="round"
                />

                {/* Vertical Frame Pillars */}
                <path
                    d="M35 55 V130 M100 90 V165 M165 55 V130"
                    stroke="#1E3A8A"
                    strokeWidth="8"
                    strokeLinecap="round"
                />
            </svg>

            {/* Typography */}
            <div className="mt-2 text-center">
                <h1 className="text-lg font-black tracking-wider text-[#1E3A8A] dark:text-blue-400">
                    REL JAY TUGAHAN
                </h1>
                <p className="text-sm font-bold tracking-widest text-[#0284C7] dark:text-sky-300">
                    CRUD PROJECT
                </p>
            </div>
        </div>
    );
}