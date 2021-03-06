<?php
use App\Tracker\Answers\SheetsJsonFeedBuilder;

class SheetsJsonFeedBuilderTest extends TestCase
{
    public function test_it_parses_the_sheet_json()
    {
        $builder = new SheetsJsonFeedBuilder();
        $txt = file_get_contents(__DIR__ . '/serialized-fixture.txt');
        $parsed = $builder->parseSheetContent(unserialize($txt));

        $this->assertCount(49, $parsed);

        // Now, just test two random ones
        $this->assertEquals([
            'always' => "",
            'section' => "Do",
            'question' => "Short-term shelter",
            'answer' => "No, I need shelter now.",
            'body' => "Find short-term shelter [on this map](https://www.houstonshelters.org)",
        ], $parsed[0]);

        $this->assertEquals([
            'always' => "",
            'section' => "More",
            'question' => "",
            'answer' => "",
            'body' => "[See if your home is in an area declared for FEMA Individual Assistance](https://www.disasterassistance.gov/address-lookup)",
        ], $parsed[36]);
    }

    public function test_it_builds_content_map()
    {
        $builder = new SheetsJsonFeedBuilder();
        $txt = file_get_contents(__DIR__ . '/serialized-fixture.txt');
        $parsed = $builder->parseSheetContent(unserialize($txt));
        $built = $builder->buildJsonData($parsed);

        $this->assertCount(17, $built);

        // This is really gross, but I just took a snapshot of what it should be based on the serialized-fixture.
        $this->assertEquals(
            json_decode('{"Short-term shelter":{"No, I need shelter now.":{"do":[{"type":"html","body":"Find short-term shelter <a href=\"https:\/\/www.houstonshelters.org\">on this map<\/a>"}]}},"Do you need non-emergency medical help? (This will direct you to information, not call for help.)":{"I need support for prescriptions.":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.pharmacy.texas.gov\/files_pdf\/Payer_Pharmacies_Info.pdf\">Get prescription assistance<\/a> from the TX State Board of Pharmacy"}]},"I need support for dialysis.":{"do":[{"type":"html","body":"Get dialysis or related procedures at TEEC toll-free at (866) 407-ESRD or <a href=\"http:\/\/www.texasteec.org\">www.texasteec.org<\/a>"}]},"I need support for a chronic illness.":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.medicare.gov\">Find Medicare support for chronic illness <\/a>"}]}},"Do you need to find anything?":{"People.":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.namus.gov\">Find missing persons at the US DOJ<\/a>"}]},"PetsAnimals.":{"do":[{"type":"html","body":"Find missing pets at the <a href=\"http:\/\/www.humanesociety.org\/news\/resources\/facts\/harvey_faq.html#harvey2\">Humane Society<\/a> and <a href=\"http:\/\/harveypets.org\/\">harveypets.org<\/a>"}]},"Autos.":{"do":[{"type":"html","body":"<a href=\"http:\/\/findmytowedcar.com\">Find your car<\/a> at the City of Houston"}]}},"Do you currently have safe shelter?":{"No, I need shelter now.":{"do":[{"type":"html","body":"Find short-term shelter <a href=\"https:\/\/www.houstonshelters.org\">on this map<\/a>"}]},"No, I have shelter now, but I need long-term shelter.":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.disasterassistance.gov\/get-assistance\/forms-of-assistance\/4471?s=0&amp;id=D10\">Find long-term housing assistance at FEMA<\/a>"}]}},"What kind of food aid do you need? Short-term, long-term or both?":{"I need short-term supplies.":{"do":[{"type":"html","body":"<a href=\"https:\/\/hhs.texas.gov\/services\/financial\/disaster-assistance\/disaster-snap\">Find TX Supplemental Nutrition Assistance Program (SNAP) assistance here<\/a> or call 2-1-1"}]},"I need long-term supplies (Meals-on-Wheels, food stamps, or similar aid).":{"do":[{"type":"html","body":"<a href=\"http:\/\/www.houstonfoodbank.org\/get-involved\/harvey-disaster-relief\/\">Contact the Houston Food Bank<\/a> or call 2-1-1"}]}},"_all":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/media-library-data\/1505143234654-0094f4d1a798c1d5175d7e11a114e77a\/disaster-survivors-checklist.pdf\">Get FEMA\'s Disaster Survivor\u2019s Checklist<\/a>"}],"":[{"type":"html","body":"Find volunteer lawyers at <a href=\"https:\/\/www.makejusticehappen.org\">Houston Volunteer Lawyers<\/a> and <a href=\"http:\/\/lonestarlegal.org\">Lone Star Legal Aid<\/a>"}],"know":[{"type":"html","body":"You can <a href=\"http:\/\/asd.fema.gov\/inter\/locator\/home.htm\">get help in person from a FEMA Disaster Recovery Center<\/a>"},{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/media-library-data\/1504483560615-c91b07f455be16d5eff4cf30f3b82dfe\/FINAL-9.3-version-after-applying-01_large.jpg\">What to expect<\/a> after you apply for FEMA assistance."},{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/mobile-app\">FEMA has an app<\/a> with additional resources"},{"type":"html","body":"FEMA can help you with needs not covered by your insurance or give you money while you wait on insurance money"},{"type":"html","body":"How to <a href=\"https:\/\/www.usa.gov\/hurricane-harvey#item-213436\">Replace Your Lost or Destroyed Vital Documents<\/a>"},{"type":"html","body":"<a href=\"https:\/\/stationhouston.zendesk.com\/hc\/en-us\/articles\/115001752574-USDHHS-Mental-and-Behavioral-Health\">Read about caring for your mental health<\/a> in an article from the US Department of Health and Human Services"},{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/resources-people-disabilities-access-functional-needs\">Browse through disaster recovery VIDEOS<\/a> from FEMA"},{"type":"html","body":"<a href=\"https:\/\/www.disasterassistance.gov\/get-assistance\/other-recovery-help\">Find help for a business, local government, or community<\/a>"},{"type":"html","body":"<a href=\"https:\/\/www.disasterassistance.gov\/get-assistance\/assistance-by-category\">View assistance by category at FEMA<\/a>"}],"more":[{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/disaster\/4332\/updates\/rumor-control\">Combat FEMA Harvey rumors<\/a>"},{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/resources-people-disabilities-access-functional-needs\">Find resources for people with disabilities, access &amp; functional needs<\/a>"},{"type":"html","body":"<a href=\"https:\/\/hhs.texas.gov\/services\/financial\/disaster-assistance\">See Texas HHS disaster assistance info<\/a>"}]},"Do you have property damage?":{"Yes":{"know":[{"type":"html","body":"<a href=\"http:\/\/www.bakerbotts.com\/aboutus\/harvey-crisis-response-group\/harvey-crisis-response-guide\">Find info about handling property damage<\/a> at this private company\u2019s site"}]}},"Do you have damage or loss? (Even if you don\'t think you need it, file with FEMA for assistance to help document damage.)":{"Have insurance and need contact info and reporting tips":{"do":[{"type":"html","body":"<a href=\"http:\/\/www.tdi.texas.gov\/consumer\/storms\/helpafterharvey.html\">Find claims info<\/a> from the Texas Department of Insurance (TDI) and <a href=\"https:\/\/www.fema.gov\/individual-disaster-assistance\">info from FEMA<\/a> "}]},"No insurance":{"do":[{"type":"html","body":"Find info about handling property damage <a href=\"http:\/\/www.bakerbotts.com\/aboutus\/harvey-crisis-response-group\/harvey-crisis-response-guide\">at this private company\u2019s site<\/a>"}]}},"Are you the property owner?":{"Yes":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/information-policyholders\">Research FEMA flood insurance details<\/a>"}]}},"Do you need help mucking your property?":{"Yes":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.texasrescuemap.com\/muckmap\">Find help mucking your house<\/a>"},{"type":"html","body":"<a href=\"https:\/\/www.texasrescuemap.com\/muckmap\">Find mucking instructions and resources<\/a>"}]}},"children":{">0":{"do":[{"type":"html","body":"<a href=\"http:\/\/www.houstonisd.org\/harvey\">Find HISD schedules<\/a>"},{"type":"html","body":"<a href=\"https:\/\/www.fema.gov\/media-library\/assets\/documents\/136310\">Keep children safe<\/a>"}]}},"infants":{">0":{"do":[{"type":"html","body":"<a href=\"http:\/\/texaswic.dshs.state.tx.us\/wiclessons\/english\/about\/\">Get support from the TX Women Infants and Children (WIC) program<\/a>"}]}},"pets":{">0":{"do":[{"type":"html","body":"<a href=\"https:\/\/www.spca.org\/hurricane-harvey\">Get free relief for pets affected by Harvey<\/a>"}]}},"Federal agency":{"":{"more":[{"type":"html","body":"<a href=\"http:\/\/www.usa.gov\">www.usa.gov<\/a>"},{"type":"html","body":"<a href=\"http:\/\/www.disasterassistance.gov\">www.disasterassistance.gov<\/a>"},{"type":"html","body":"<a href=\"http:\/\/www.fema.gov\">www.fema.gov<\/a>"}]}},"State agency":{"":{"more":[{"type":"html","body":"<a href=\"http:\/\/www.dps.texas.gov\/dem\/\"><a href=\"http:\/\/www.dps.texas.gov\/dem\/\">http:\/\/www.dps.texas.gov\/dem\/<\/a><\/a>"},{"type":"html","body":"<a href=\"http:\/\/dshs.texas.gov\"><a href=\"http:\/\/dshs.texas.gov\">http:\/\/dshs.texas.gov<\/a><\/a>"}]}},"County agency":{"":{"more":[{"type":"html","body":"<a href=\"http:\/\/www.harriscountytx.gov\"><a href=\"http:\/\/www.harriscountytx.gov\">http:\/\/www.harriscountytx.gov<\/a><\/a>"}]}},"City agency":{"":{"more":[{"type":"html","body":"<a href=\"http:\/\/www.houstontx.gov\"><a href=\"http:\/\/www.houstontx.gov\">http:\/\/www.houstontx.gov<\/a><\/a>"}]}}}', true),
            $built,
            "failed do return correct built"
        );


    }

}
