export function ValueProps() {
  return (
    <section className="w-full py-20 px-8 bg-white">
      <div className="max-w-5xl w-full mx-auto">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="text-center space-y-2">
            <div className="text-2xl font-bold text-[#0A0A0A]">Precision</div>
            <div className="text-sm text-[#6B6B6B] font-mono">
              Every byte has purpose.
            </div>
          </div>
          <div className="text-center space-y-2">
            <div className="text-2xl font-bold text-[#0A0A0A]">
              Verification
            </div>
            <div className="text-sm text-[#6B6B6B] font-mono">
              Facts built for proof, not polish.
            </div>
          </div>
          <div className="text-center space-y-2">
            <div className="text-2xl font-bold text-[#0A0A0A]">
              Transparency
            </div>
            <div className="text-sm text-[#6B6B6B] font-mono">
              Visible, structured, and impossible to fake.
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
