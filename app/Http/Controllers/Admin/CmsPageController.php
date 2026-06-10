<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    // =========================
    // ADMIN: LIST ALL PAGES
    // =========================
    public function index()
    {
        return CmsPage::latest()->get();
    }

    // =========================
    // ADMIN: CREATE PAGE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page = CmsPage::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'status' => $request->status ?? 1,
        ]);

        return response()->json($page);
    }

    // =========================
    // ADMIN: SHOW SINGLE PAGE
    // =========================
    public function show($id)
    {
        return CmsPage::findOrFail($id);
    }

    // =========================
    // ADMIN: UPDATE PAGE
    // =========================
    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);

        $data = $request->only([
            'title',
            'slug',
            'content',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'status'
        ]);

        if (isset($data['slug']) && !empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $page->update($data);

        return response()->json([
            'message' => 'Page updated successfully',
            'data' => $page
        ]);
    }

    // =========================
    // ADMIN: DELETE PAGE
    // =========================
    public function destroy($id)
    {
        CmsPage::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Page deleted successfully'
        ]);
    }

    // =========================
    // ADMIN: GENERATE DEFAULT PAGES
    // =========================
    public function generateDefaults()
    {
        $aboutUsContent = '<h2>SG Holidays Resorts - Where Every Moment Feels Like a Dream Vacation!</h2><h3>Crafting Seamless &amp; Unforgettable Journeys Across India</h3><p>At <strong>Sree Gowthamaaditya Holidays &amp; Resorts (SGH)</strong>, we believe travel is not just about visiting new places—it\'s about creating memories, discovering cultures, and experiencing the joy of stress-free journeys.</p><hr /><h2>Our Core Philosophy</h2><h3>Our Mission</h3><p>To create seamless, memorable, and stress-free travel experiences across India by offering expertly curated itineraries, quality services, and personalized hospitality.</p><h3>Our Vision</h3><p>To be India\'s most trusted travel brand, known for delivering unmatched travel experiences, exceptional service, and complete travel solutions.</p><h3>Our Values</h3><p><strong>Customer First</strong> – Your comfort and satisfaction are our top priorities.<br /><strong>Excellence</strong> – We ensure high-quality services at every step.<br /><strong>Integrity</strong> – Transparency and trust define our work.</p><hr /><h2>What SG Holidays Resorts Offers</h2><ul><li><strong>Hassle-Free Travel</strong> – We take care of transportation, accommodations, sightseeing, and curated experiences so you can travel worry-free.</li><li><strong>Personalized Itineraries –</strong> Whether it\'s a relaxing getaway, an adventure-packed vacation, or a heritage tour, we customize your journey to suit your preferences.</li><li><strong>Top-Notch Hospitality –</strong> We partner with the best hotels and travel service providers to ensure comfort and quality throughout your trip.</li><li><strong>Expert Guidance –</strong> Our team of travel experts ensures a smooth experience, from planning to execution.</li></ul><hr /><h2>Why Choose SG Holidays Resorts?</h2><ul><li><strong>🏆 National Award-Winning Brand</strong>: Recognized for excellence in the travel industry.</li><li><strong>🌍 Pan-India Destinations</strong>: From pristine beaches to majestic mountains, we cover it all.</li><li><strong>✈️ End-to-End Travel Solutions</strong>: Flights, stays, transport, food, and sightseeing—everything is taken care of.</li><li><strong>🤝 Customer-Centric Approach</strong>: We prioritize your comfort, convenience, and satisfaction.</li><li><strong>💼 Expertly Managed Vacations</strong>: With SGH, your dream holiday is just a booking away. We plan, manage, and perfect your journey from start to finish.</li></ul>';

        $privacyPolicyContent = '<h1>Privacy Policy Of SG Holidays Resorts</h1>
<p>At <strong>SG Holidays Resorts (Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.)</strong>, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.</p>
<p>Please read this policy carefully. If you disagree with its terms, please discontinue use of the site.</p>

<h2>1. Information We Collect</h2>
<p>We may collect information about you in a variety of ways:</p>
<h3>Personal Data</h3>
<p>When you make a booking or inquiry, we may collect personally identifiable information, such as your:</p>
<ul>
<li>Full Name</li>
<li>Email Address</li>
<li>Phone Number</li>
<li>Postal / Home Address</li>
<li>Date of Birth (for travel document purposes)</li>
<li>Passport / ID details (for international travel)</li>
<li>Payment information (processed securely via third-party gateways)</li>
</ul>
<h3>Derivative Data</h3>
<p>Information our servers automatically collect when you access the Site, such as your IP address, browser type, operating system, access times, and the pages you have viewed directly before and after accessing the Site.</p>
<h3>Financial Data</h3>
<p>Financial information, such as data related to your payment method (e.g., valid credit card number, card brand, expiration date) is collected only as needed to process your payments. We store only very limited, if any, financial information. For all payment details, we rely on PCI-DSS compliant payment processors.</p>

<h2>2. Use of Your Information</h2>
<p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the Site to:</p>
<ul>
<li>Process and confirm your travel bookings</li>
<li>Send you booking confirmations and itinerary updates</li>
<li>Contact you about promotions and special offers (with your consent)</li>
<li>Respond to customer service requests and support needs</li>
<li>Improve our website and services based on user feedback</li>
<li>Prevent fraudulent transactions and monitor against theft</li>
<li>Comply with legal and regulatory requirements</li>
</ul>

<h2>3. Disclosure of Your Information</h2>
<p>We may share information we have collected about you in certain situations. Your information may be disclosed as follows:</p>
<h3>By Law or to Protect Rights</h3>
<p>If we believe the release of information about you is necessary to respond to legal process, to investigate or remedy potential violations of our policies, or to protect the rights, property, and safety of others, we may share your information as permitted or required by any applicable law, rule, or regulation.</p>
<h3>Third-Party Service Providers</h3>
<p>We may share your information with third parties that perform services for us or on our behalf, including payment processing, data analysis, email delivery, hosting services, and customer service. These service providers are only provided with the information necessary to perform their designated functions.</p>
<h3>Travel Partners</h3>
<p>We may share your information with our travel service partners such as hotels, airlines, transport providers, and tour operators solely for the purpose of fulfilling your booked services.</p>

<h2>4. Security of Your Information</h2>
<p>We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable.</p>

<h2>5. Cookies and Tracking Technologies</h2>
<p>We may use cookies, web beacons, tracking pixels, and other tracking technologies on the Site to help customize the Site and improve your experience. By using the Site, you agree to be bound by our Cookie Policy.</p>

<h2>6. Third-Party Websites</h2>
<p>The Site may contain links to third-party websites and applications of interest, including advertisements and external services. Once you have used these links to leave our Site, any information you provide to these third parties is not covered by this Privacy Policy. We cannot guarantee the safety and privacy of information you provide to any third parties.</p>

<h2>7. Your Rights</h2>
<p>You have certain rights regarding your personal data, including the right to:</p>
<ul>
<li>Access the personal data we hold about you</li>
<li>Request correction of inaccurate data</li>
<li>Request deletion of your personal data</li>
<li>Opt out of marketing communications at any time</li>
<li>Lodge a complaint with a supervisory authority</li>
</ul>
<p>To exercise any of these rights, please contact us at <strong>info@sgholidaysresorts.com</strong> or call us at <strong>+91 92811 11733</strong>.</p>

<h2>8. Children\'s Privacy</h2>
<p>Our website and services are not directed to children under the age of 13. We do not knowingly collect personally identifiable information from children under 13. If you are under 13, please do not use our services or provide any personal information.</p>

<h2>9. Changes to This Policy</h2>
<p>We reserve the right to make changes to this Privacy Policy at any time and for any reason. We will alert you about any changes by updating the "Last Updated" date of this Privacy Policy. You are encouraged to periodically review this Privacy Policy to stay informed of updates.</p>

<h2>10. Contact Us</h2>
<p>If you have questions or comments about this Privacy Policy, please contact us at:</p>
<p><strong>Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.</strong><br />
Email: info@sgholidaysresorts.com<br />
Phone: +91 92811 11733<br />
Website: sgholidaysresorts.com</p>';

        $termsContent = '<h1>Terms and Conditions</h1>
<p>Welcome to <strong>SG Holidays Resorts (Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.)</strong>. By accessing our website or booking any of our services, you agree to be bound by the following Terms and Conditions. Please read them carefully before making a reservation.</p>

<h2>1. Acceptance of Terms</h2>
<p>By using this website or making a booking with us, you confirm that you have read, understood, and agree to these Terms and Conditions. If you do not agree with any part of these terms, please do not use our services.</p>

<h2>2. Booking and Payment</h2>
<ul>
<li>All bookings are subject to availability and confirmed only upon receipt of the required deposit.</li>
<li>A non-refundable booking deposit of 20% of the total package cost is required at the time of booking to secure your reservation.</li>
<li>The remaining balance must be paid in full at least 15 days prior to the departure date.</li>
<li>Failure to make payment by the due date may result in automatic cancellation of your booking.</li>
<li>All prices are quoted in Indian Rupees (INR) and include applicable taxes unless otherwise stated.</li>
<li>We accept payments via bank transfer, UPI, credit/debit cards, and other approved digital payment methods.</li>
</ul>

<h2>3. Pricing</h2>
<ul>
<li>All package prices are subject to change without prior notice due to factors such as fuel surcharges, airline fare changes, seasonal pricing, and government taxes.</li>
<li>Quoted prices are valid only at the time of booking and may differ from rates advertised at other times.</li>
<li>We reserve the right to correct any errors in pricing and will inform you of the corrected price before confirming your booking.</li>
</ul>

<h2>4. Travel Documents and Requirements</h2>
<ul>
<li>It is the sole responsibility of the traveler to ensure they hold valid travel documents including passports, visas, health certificates, and other required documentation.</li>
<li>SG Holidays Resorts will not be held liable for any loss or expense incurred due to incomplete or invalid travel documents.</li>
<li>Travelers are advised to obtain comprehensive travel insurance before departure.</li>
</ul>

<h2>5. Itinerary Changes</h2>
<ul>
<li>SG Holidays Resorts reserves the right to modify itineraries, accommodations, or services due to operational or unforeseen circumstances such as weather conditions, natural disasters, or safety concerns.</li>
<li>Where possible, we will provide alternatives of equivalent or superior standard at no additional cost.</li>
<li>We are not liable for any losses or expenses resulting from itinerary changes beyond our control.</li>
</ul>

<h2>6. Liability</h2>
<ul>
<li>SG Holidays Resorts acts as an agent for hotels, airlines, transport companies, and other service providers.</li>
<li>We are not liable for any injury, damage, loss, accident, delay, or irregularity that may occur through the fault of any supplier or third-party service provider.</li>
<li>Our liability in any case shall be limited to the total cost of the package booked.</li>
</ul>

<h2>7. Health and Safety</h2>
<ul>
<li>Travelers are responsible for ensuring they are medically fit to travel.</li>
<li>Any pre-existing medical conditions must be disclosed at the time of booking.</li>
<li>We are not responsible for any medical expenses or losses arising from illness during a trip.</li>
</ul>

<h2>8. Force Majeure</h2>
<p>SG Holidays Resorts shall not be responsible for any failure or delay in performance arising from circumstances beyond our reasonable control, including but not limited to: natural disasters, acts of terrorism, war, pandemics, government restrictions, or strikes.</p>

<h2>9. Intellectual Property</h2>
<p>All content on this website, including text, images, logos, and other materials, is the property of SG Holidays Resorts and is protected by applicable intellectual property laws. Unauthorized use, reproduction, or distribution of any content is strictly prohibited.</p>

<h2>10. Governing Law</h2>
<p>These Terms and Conditions shall be governed by and construed in accordance with the laws of India. Any disputes arising shall be subject to the exclusive jurisdiction of the courts in Hyderabad, Telangana.</p>

<h2>11. Amendments</h2>
<p>SG Holidays Resorts reserves the right to update or modify these Terms and Conditions at any time without prior notice. Continued use of our website or services following any changes constitutes your acceptance of the revised terms.</p>

<h2>12. Contact Us</h2>
<p>For any questions or concerns regarding these Terms and Conditions, please contact us:</p>
<p><strong>Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.</strong><br />
Email: info@sgholidaysresorts.com<br />
Phone: +91 92811 11733</p>';

        $cancellationRefundContent = '<h1>Cancellation and Refund Policy</h1>
<p>At <strong>SG Holidays Resorts (Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.)</strong>, we understand that travel plans can change unexpectedly. This Cancellation and Refund Policy outlines the terms for cancelling a booking and the process for obtaining a refund.</p>
<p>Please read this policy carefully before making any booking. By booking with us, you agree to the terms stated herein.</p>

<h2>1. Cancellation by the Customer</h2>
<p>All cancellation requests must be submitted in writing via email to info@sgholidaysresorts.com or by contacting us at +91 92811 11733. Cancellations will be effective from the date of written confirmation received by us.</p>

<h3>Standard Cancellation Charges</h3>
<table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
<thead>
<tr style="background-color:#f5f5f5;">
<th>Days Before Departure</th>
<th>Cancellation Charge</th>
</tr>
</thead>
<tbody>
<tr>
<td>More than 30 days</td>
<td>Booking deposit only (20% of total cost)</td>
</tr>
<tr>
<td>15 – 30 days</td>
<td>50% of total package cost</td>
</tr>
<tr>
<td>7 – 14 days</td>
<td>75% of total package cost</td>
</tr>
<tr>
<td>Less than 7 days / No-Show</td>
<td>100% of total package cost (No Refund)</td>
</tr>
</tbody>
</table>
<p><strong>Note:</strong> The booking deposit is non-refundable in all circumstances.</p>

<h2>2. Cancellation of Air Tickets</h2>
<ul>
<li>Air ticket cancellations are subject to the individual airline\'s cancellation and refund policies.</li>
<li>SG Holidays Resorts will not be responsible for any airline-imposed cancellation fees or changes in fare rules.</li>
<li>Low-cost carrier tickets may be non-refundable once issued.</li>
</ul>

<h2>3. Cancellation of Hotel Bookings</h2>
<ul>
<li>Hotel cancellation policies vary by property and season.</li>
<li>In peak season or during special events, hotels may have stricter non-refundable booking conditions.</li>
<li>Any hotel-specific cancellation fees will be charged in addition to our standard charges.</li>
</ul>

<h2>4. Refund Process</h2>
<ul>
<li>Refunds will be processed only after receiving the written cancellation request and verification of the booking details.</li>
<li>Approved refunds will be credited to the original payment method (bank account or card) within <strong>7–14 business days</strong> from the date of cancellation approval.</li>
<li>Refunds will be processed in Indian Rupees (INR), and any currency conversion charges are the traveler\'s responsibility.</li>
</ul>

<h2>5. Non-Refundable Items</h2>
<p>The following costs are typically non-refundable and will be deducted from any refund:</p>
<ul>
<li>Booking/reservation deposits</li>
<li>Visa fees and documentation charges</li>
<li>Travel insurance premiums</li>
<li>Non-refundable air tickets or hotel bookings</li>
<li>Any costs for services already rendered or consumed</li>
</ul>

<h2>6. Cancellation Due to Force Majeure</h2>
<p>In events of force majeure (e.g., natural disasters, pandemics, government-imposed travel restrictions), SG Holidays Resorts will make every effort to offer alternative travel dates or a credit note valid for 12 months. Full cash refunds may not be possible in such circumstances due to non-recoverable costs paid to suppliers.</p>

<h2>7. Cancellation by SG Holidays Resorts</h2>
<p>In rare cases where SG Holidays Resorts must cancel your booking (e.g., insufficient participants for a group tour, force majeure events, or circumstances beyond our control), we will:</p>
<ul>
<li>Notify you as soon as possible</li>
<li>Offer an alternative package of equal or higher value</li>
<li>Provide a full refund if no suitable alternative is available</li>
</ul>

<h2>8. How to Request a Cancellation or Refund</h2>
<p>To initiate a cancellation or refund request:</p>
<ol>
<li>Email us at info@sgholidaysresorts.com with your booking reference number and reason for cancellation.</li>
<li>Our team will acknowledge your request within 24–48 business hours.</li>
<li>Once the cancellation is processed, you will receive a confirmation with the applicable refund amount.</li>
<li>The refund will be credited within 7–14 business days.</li>
</ol>

<h2>9. Contact Us</h2>
<p>For any questions regarding this policy, please reach out to us:</p>
<p><strong>Sree Gowthamaaditya Holidays &amp; Resorts Pvt. Ltd.</strong><br />
Email: info@sgholidaysresorts.com<br />
Phone: +91 92811 11733<br />
Website: sgholidaysresorts.com</p>';

        $defaults = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => $aboutUsContent,
                'meta_title' => 'About Us | SG Holidays Resorts #1 Best Travel Agencies',
                'meta_description' => 'Discover who we are in our About Us section — a trusted travel partner dedicated to crafting seamless, memorable, and affordable holiday experiences.',
                'meta_keywords' => 'about us, sg holidays, travel agency, custom tours, vacation planning',
                'status' => 1,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => $privacyPolicyContent,
                'meta_title' => 'Privacy Policy Of SG Holidays Resorts #1 Best Travel Package',
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal data when you visit or book with us online.',
                'meta_keywords' => 'privacy policy, security, data protection, sg holidays',
                'status' => 1,
            ],
            [
                'title' => 'Cancellation and Refund Policy',
                'slug' => 'cancellation-and-refund-policy',
                'content' => $cancellationRefundContent,
                'meta_title' => 'Cancellation And Refund Policy - SG Holidays Resorts',
                'meta_description' => 'Review SG Holidays & Resorts\' Cancellation and Refund Policy for travel bookings, packages, and resort stays. Know your rights before making reservations.',
                'meta_keywords' => 'cancellation policy, refund policy, cancel booking, travel policy, sg holidays',
                'status' => 1,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'content' => $termsContent,
                'meta_title' => 'Terms and Conditions - SG Holidays Resorts',
                'meta_description' => 'Read the official Terms and Conditions of booking with SG Holidays Resorts. Understand your rights and obligations when booking with us.',
                'meta_keywords' => 'terms and conditions, user agreement, booking terms, legal, sg holidays',
                'status' => 1,
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<h2>Disclaimer</h2><p>The information provided on this website is for general informational purposes only. While we endeavor to keep the information up-to-date and correct, we make no representations of any kind regarding accuracy or completeness.</p><p>SG Holidays acts only as an agent for the providers of accommodation, transport, and sightseeing tours. We are not liable for injury, damage, loss, or delay caused by any service provider.</p>',
                'meta_title' => 'Disclaimer - SG Holidays',
                'meta_description' => 'Official disclaimer regarding website content, accuracy, and liability of SG Holidays.',
                'meta_keywords' => 'disclaimer, liability, terms of service, sg holidays',
                'status' => 1,
            ],
            [
                'title' => 'Booking Policy',
                'slug' => 'booking-policy',
                'content' => '<h2>Booking Policy</h2><p>Booking with SG Holidays is simple and secure. To confirm a booking, a deposit of 20% of the total tour cost is required at the time of reservation.</p><p>The remaining balance must be paid at least 15 days before the departure date. We accept major credit cards, bank transfers, and digital payments.</p>',
                'meta_title' => 'Booking Policy - SG Holidays',
                'meta_description' => 'Read our Booking Policy for details on deposit payments, balance dues, and confirmation procedures.',
                'meta_keywords' => 'booking policy, payment terms, deposit, confirm travel',
                'status' => 1,
            ]
        ];

        $created = 0;
        foreach ($defaults as $data) {
            $page = CmsPage::where('slug', $data['slug'])->first();
            if (!$page) {
                CmsPage::create($data);
                $created++;
            } else {
                // Always update content for all default pages
                $page->update([
                    'title'            => $data['title'],
                    'content'          => $data['content'],
                    'meta_title'       => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                    'meta_keywords'    => $data['meta_keywords'],
                ]);
                $created++;
            }
        }

        return response()->json([
            'message' => "Successfully processed. {$created} default pages were generated/updated.",
            'created_count' => $created
        ]);
    }

    // =========================
    // PUBLIC: LIST ALL ACTIVE PAGES
    // =========================
    public function publicIndex()
    {
        return CmsPage::where('status', 1)->select('id', 'title', 'slug')->get();
    }

    // =========================
    // PUBLIC: GET PAGE BY SLUG
    // =========================
    public function getBySlug($slug)
    {
        return CmsPage::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();
    }
}