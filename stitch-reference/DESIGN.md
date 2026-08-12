---
name: Queer Ink Editorial
colors:
  surface: '#fff8f7'
  surface-dim: '#edd4d6'
  surface-bright: '#fff8f7'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#fff0f1'
  surface-container: '#ffe9ea'
  surface-container-high: '#fbe2e4'
  surface-container-highest: '#f6ddde'
  on-surface: '#25181a'
  on-surface-variant: '#584143'
  inverse-surface: '#3c2d2e'
  inverse-on-surface: '#ffeced'
  outline: '#8c7073'
  outline-variant: '#e0bec1'
  surface-tint: '#b2254a'
  primary: '#7a002a'
  on-primary: '#ffffff'
  primary-container: '#a0153e'
  on-primary-container: '#ffb0ba'
  inverse-primary: '#ffb2bb'
  secondary: '#5f5e5e'
  on-secondary: '#ffffff'
  secondary-container: '#e2dfde'
  on-secondary-container: '#636262'
  tertiary: '#383a49'
  on-tertiary: '#ffffff'
  tertiary-container: '#4f5161'
  on-tertiary-container: '#c4c4d7'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffd9dd'
  primary-fixed-dim: '#ffb2bb'
  on-primary-fixed: '#400012'
  on-primary-fixed-variant: '#900234'
  secondary-fixed: '#e5e2e1'
  secondary-fixed-dim: '#c8c6c5'
  on-secondary-fixed: '#1c1b1b'
  on-secondary-fixed-variant: '#474746'
  tertiary-fixed: '#e1e1f5'
  tertiary-fixed-dim: '#c5c5d8'
  on-tertiary-fixed: '#191b29'
  on-tertiary-fixed-variant: '#444655'
  background: '#fff8f7'
  on-background: '#25181a'
  surface-variant: '#f6ddde'
typography:
  display-lg:
    fontFamily: Playfair Display
    fontSize: 64px
    fontWeight: '700'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Playfair Display
    fontSize: 40px
    fontWeight: '700'
    lineHeight: '1.2'
  headline-lg:
    fontFamily: Playfair Display
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.3'
  headline-md:
    fontFamily: Playfair Display
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: '1.2'
    letterSpacing: 0.05em
  caption:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: '1.4'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 8px
  gutter: 24px
  margin-desktop: 64px
  margin-mobile: 20px
  max-width: 1280px
---

## Brand & Style

This design system embodies a **Modern Editorial** aesthetic, positioning the platform as a sophisticated cultural institution. It prioritizes intellectual depth and archival permanence through a blend of classical typographic discipline and contemporary digital layouts. 

The visual narrative is "Contemporary Heritage"—honoring the history of queer narratives in India while maintaining a clean, premium, and accessible interface. The style utilizes **Minimalism** with **Tactile** accents; it avoids heavy shadows in favor of purposeful whitespace, thin rules, and high-quality photography. The emotional response should be one of warmth, dignity, and cultural authority.

## Colors

The palette is anchored by a deep, authoritative crimson that signals passion and urgency, grounded by a sophisticated near-black for high legibility. 

- **Primary (#A0153E):** Used for critical actions, active states, and brand-defining accents.
- **Surface & Background:** The background uses a warm off-white (#FAFAFA) to reduce eye strain and mimic high-quality paper. The pale blush (#FFF0F5) acts as a secondary surface for card containers and content categorization.
- **Accents:** Soft lavender and warm peach are reserved for subtle background washes, tag backgrounds, or decorative highlights, ensuring a diverse but cohesive queer visual spectrum.

## Typography

The typography system relies on a high-contrast pairing of a sophisticated serif and a utilitarian sans-serif.

- **Headlines:** Use **Playfair Display** for all editorial content, titles, and large-scale pull quotes. Use "optical sizing" logic—tighter tracking for larger sizes to maintain the premium feel.
- **Body & UI:** Use **Inter** for all functional text, long-form reading, and interface labels. Its neutral, geometric nature ensures the platform feels modern and does not compete with the expressive serif.
- **Hierarchy:** Use the uppercase `label-md` for categories, dates, and metadata to provide a clear structural break between headers and body content.

## Layout & Spacing

This design system utilizes an **Asymmetric Fluid Grid** to reflect the dynamic nature of storytelling. 

- **Desktop:** A 12-column grid with generous 64px side margins. Content should often be offset—for example, a headline spanning 8 columns starting from column 3—to create an editorial, non-linear feel.
- **Rhythm:** Spacing follows an 8px base unit. Vertical rhythm is critical; use `64px` or `80px` gaps between major sections to emphasize the "clean" aesthetic.
- **Responsive:** On mobile, transition to a 4-column grid with 20px margins. Headlines should scale down significantly to maintain readability while preserving their serif character.

## Elevation & Depth

In line with the "Editorial" theme, depth is communicated through **Tonal Layers** rather than heavy shadows.

- **Flat Surfaces:** Most elements sit directly on the background or surface containers.
- **Dividers:** Use thin (1px) rules in a very light grey or the accent lavender to separate sections.
- **Subtle Elevation:** For interactive cards, use an extremely soft, large-radius shadow (e.g., `0px 4px 20px rgba(0,0,0,0.04)`) to suggest a lift upon hover.
- **Glassmorphism:** Use sparingly for sticky navigation bars with a background blur (10px) and a semi-transparent `#FAFAFA` fill to maintain context while scrolling.

## Shapes

The shape language is **Soft and Balanced**. Elements are rounded enough to feel approachable and warm, but not so much that they lose their professional, institutional edge.

- **Cards & Inputs:** Use the `rounded-lg` (12px/1rem) setting as the standard for all content containers and input fields.
- **Buttons:** Primary buttons should be slightly more rounded (`rounded-xl`) to contrast against the more rectangular nature of text blocks.
- **Decorative Elements:** Use perfectly circular shapes for avatars and specific iconography to provide a geometric counterpoint to the editorial layout.

## Components

- **Buttons:** The primary button is solid crimson (#A0153E) with white text. Secondary buttons use a thin crimson border with no fill. Always use `label-md` typography for button text to ensure clarity.
- **Editorial Cards:** Large 12px corner radius. Background is either the surface blush (#FFF0F5) or pure white. Cards should have generous internal padding (32px) and use thin dividers to separate title from metadata.
- **Chips/Tags:** Use the accent lavender or peach as background fills with dark text. These should have a pill-shape (`rounded-xl`) to differentiate them from functional buttons.
- **Inputs:** Clean, 1px border in a mid-grey. On focus, the border shifts to primary crimson. No heavy inner shadows.
- **Archival Lists:** For "Archive" sections, use high-density lists with 1px horizontal dividers and Playfair Display for the item titles, creating a "table of contents" feel.
- **Quote Block:** A signature component featuring a large serif opening quotation mark in primary crimson, with the quote text in `headline-md` Playfair Display.