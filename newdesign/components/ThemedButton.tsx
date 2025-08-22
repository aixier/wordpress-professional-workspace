"use client";

import PhSunBold from "@/components/icons/sun";
import { useTheme } from "next-themes";
import { useState, useEffect } from 'react';

export function ThemedButton() {
  const [mounted, setMounted] = useState(false);
  const { theme, setTheme } = useTheme();

  useEffect(() => {
    setMounted(true);
  }, []);

  if (!mounted) return null;

  return (
    <button
      onClick={() => setTheme(theme === "dark" ? "light" : "dark")}
      className="w-6 h-6"
      title={theme === "dark" ? "Switch to light mode" : "Switch to dark mode"}
    >
      <PhSunBold />
    </button>
  );
}