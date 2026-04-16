/**
 * Field config for each applicant sub-section.
 * The Vue SPA sends these as traveller_meta; the API stores them verbatim.
 * Labels go through $t(), so they appear in lang/*.json.
 */
export const SECTIONS = {
    personal: {
        label: 'Personal info',
        description: 'Basic identifying information for this applicant.',
        fields: [
            { key: 'first_name',   label: 'First name' },
            { key: 'last_name',    label: 'Last name' },
            { key: 'date_of_birth', label: 'Date of birth', type: 'date' },
            { key: 'gender', label: 'Gender', type: 'select', options: [
                { value: 'male',   label: 'Male' },
                { value: 'female', label: 'Female' },
                { value: 'other',  label: 'Other' },
            ] },
            { key: 'nationality', label: 'Nationality' },
            { key: 'occupation',  label: 'Occupation' },
            { key: 'address',     label: 'Address', wide: true, type: 'textarea' },
        ],
    },
    passport: {
        label: 'Passport',
        description: 'Passport information.',
        fields: [
            { key: 'passport_number',   label: 'Passport number' },
            { key: 'issuing_country',   label: 'Issuing country' },
            { key: 'issue_date',        label: 'Issue date',      type: 'date' },
            { key: 'expiration_date',   label: 'Expiration date', type: 'date' },
            { key: 'place_of_issue',    label: 'Place of issue' },
        ],
    },
    family: {
        label: 'Family',
        description: 'Family and relationship details.',
        fields: [
            { key: 'marital_status', label: 'Marital status', type: 'select', options: [
                { value: 'single',   label: 'Single' },
                { value: 'married',  label: 'Married' },
                { value: 'divorced', label: 'Divorced' },
                { value: 'widowed',  label: 'Widowed' },
            ] },
            { key: 'spouse_name',   label: 'Spouse name' },
            { key: 'father_name',   label: 'Father\'s name' },
            { key: 'mother_name',   label: 'Mother\'s name' },
            { key: 'emergency_contact', label: 'Emergency contact', wide: true, type: 'textarea' },
        ],
    },
    'past-travel': {
        label: 'Past travel',
        description: 'Recent international travel history.',
        fields: [
            { key: 'visited_countries', label: 'Countries visited (last 5 years)', wide: true, type: 'textarea' },
            { key: 'previous_visa',    label: 'Previous visa details', wide: true, type: 'textarea' },
            { key: 'refused_visa',     label: 'Have you been refused a visa?', type: 'select', options: [
                { value: 'no',  label: 'No' },
                { value: 'yes', label: 'Yes' },
            ] },
            { key: 'refused_visa_details', label: 'If yes, details', wide: true, type: 'textarea' },
        ],
    },
    declarations: {
        label: 'Declarations',
        description: 'Legal and health declarations.',
        fields: [
            { key: 'criminal_record', label: 'Do you have a criminal record?', type: 'select', options: [
                { value: 'no',  label: 'No' },
                { value: 'yes', label: 'Yes' },
            ] },
            { key: 'health_conditions', label: 'Health conditions / medication', wide: true, type: 'textarea' },
            { key: 'declaration_confirm', label: 'I confirm the above is true', type: 'select', options: [
                { value: 'yes', label: 'Yes, I confirm' },
            ] },
        ],
    },
};

export const SECTION_ORDER = ['personal', 'passport', 'family', 'past-travel', 'declarations'];
