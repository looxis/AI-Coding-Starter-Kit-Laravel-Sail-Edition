# Frontend Implementation Checklist

Before marking frontend as complete:

## Blade Components
- [ ] Checked existing Blade components via `git ls-files resources/views/components/`
- [ ] Reused existing components via `<x-component-name>` where applicable
- [ ] No duplicate components created

## Existing Code
- [ ] Checked existing views via `git ls-files resources/views/`
- [ ] Reused existing layouts and partials where possible

## Design
- [ ] Design preferences clarified with user (if no mockups or design-system.md)
- [ ] Component architecture from Solution Architect followed

## Implementation
- [ ] All planned Blade views and components implemented
- [ ] All components use Tailwind CSS (no inline styles, no CSS modules)
- [ ] ALL forms include `@csrf` directive
- [ ] Alpine.js used for reactive behavior (dropdowns, modals, form UX)
- [ ] Loading states implemented (Alpine.js `x-show` + spinner/skeleton)
- [ ] Error states implemented (user-friendly error messages)
- [ ] Empty states implemented ("No data yet" messages)

## Quality
- [ ] Responsive: Mobile (375px), Tablet (768px), Desktop (1440px)
- [ ] Accessibility: Semantic HTML, ARIA labels, keyboard navigation
- [ ] Routes defined in `routes/web.php` and verified with `php artisan route:list`
- [ ] Vite build passes: `npm run build`

## Verification (run before marking complete)
- [ ] `php artisan route:list` shows all expected routes
- [ ] All acceptance criteria from feature spec addressed in UI
- [ ] `features/INDEX.md` status updated to "In Progress"

## Completion
- [ ] User has reviewed and approved the UI in browser
- [ ] Code committed to git
