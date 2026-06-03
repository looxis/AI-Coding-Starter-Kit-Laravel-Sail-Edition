---
paths:
  - "resources/views/**"
  - "resources/js/**"
  - "resources/css/**"
---

# Frontend Development Rules

## Blade Components First (MANDATORY)
- Before creating ANY UI component, check if one already exists: `git ls-files resources/views/components/`
- NEVER duplicate an existing Blade component — reuse it via `<x-component-name>`
- Create reusable components as anonymous Blade components in `resources/views/components/`
  - Example file: `resources/views/components/button.blade.php`
  - Used as: `<x-button>Click me</x-button>`
- Custom components are ONLY for business-specific compositions

## Alpine.js for Reactivity
- Use Alpine.js for all client-side reactive behavior: dropdowns, modals, toggles, dynamic forms
- Key directives: `x-data`, `x-show`, `x-if`, `x-bind`, `x-on`, `x-model`, `x-transition`
- Keep Alpine logic inline for simple cases; extract to `resources/js/` for complex components
- No full SPA behavior — Alpine.js supplements server-rendered Blade HTML

## CSRF Protection (MANDATORY)
- ALL HTML forms must include `@csrf` Blade directive
- Never submit a POST/PUT/PATCH/DELETE form without `@csrf`

## Component Standards
- Use Tailwind CSS exclusively (no inline styles, no CSS modules)
- All templates must be responsive (mobile 375px, tablet 768px, desktop 1440px)
- Implement loading states (Alpine.js `x-show` + spinner), error states, and empty states
- Use semantic HTML and ARIA labels for accessibility
- Keep Blade components small and focused — one component per file
