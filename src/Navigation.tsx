import React, { useState, useEffect, useRef } from 'react';

export function Navigation() {
  const [isOpen, setIsOpen] = useState(false);
  const toggleButtonRef = useRef<HTMLButtonElement>(null);
  const navMenuRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (
        isOpen &&
        toggleButtonRef.current &&
        navMenuRef.current &&
        !toggleButtonRef.current.contains(event.target as Node) &&
        !navMenuRef.current.contains(event.target as Node)
      ) {
        setIsOpen(false);
      }
    };

    document.addEventListener('click', handleClickOutside);
    return () => document.removeEventListener('click', handleClickOutside);
  }, [isOpen]);

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  return (
    <div className="fixed top-4 left-4 z-50">
      {/* Plus Icon Button */}
      <button
        ref={toggleButtonRef}
        onClick={toggleMenu}
        className="w-10 h-10 flex items-center justify-center bg-white border-2 border-[#0A0A0A] hover:bg-[#F8F8F8] transition-colors duration-200 group"
        aria-label="Toggle menu"
      >
        {/* Plus Icon */}
        <svg
          className={`w-5 h-5 text-[#0A0A0A] transition-transform duration-200 ${isOpen ? 'hidden' : 'block'}`}
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path>
        </svg>
        {/* Close Icon */}
        <svg
          className={`w-5 h-5 text-[#0A0A0A] transition-transform duration-200 ${isOpen ? 'block' : 'hidden'}`}
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>

      {/* Navigation Menu Overlay */}
      <div
        ref={navMenuRef}
        className={`absolute top-12 left-0 bg-white border-2 border-[#0A0A0A] shadow-lg w-48 transition-all duration-200 ${
          isOpen ? 'block' : 'hidden'
        }`}
      >
        <nav className="p-4 space-y-2">
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Home
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Dashboard
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Admin
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-red-600 font-medium hover:bg-red-50 transition-colors duration-200"
          >
            Logout
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Login
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Understand
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Get Started
          </a>
          <a
            href="#"
            className="block px-4 py-2 text-[#0A0A0A] font-medium hover:bg-[#F8F8F8] transition-colors duration-200"
          >
            Documentation
          </a>
        </nav>
      </div>
    </div>
  );
}
