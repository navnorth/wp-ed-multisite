jQuery(document).ready(function ($) {

    var TRUE = "TRUE";

    /* constants/enums used by the script */
    DataSetIndexes = {
        RESOURCE_ID: 0,
        TITLE: 1,
        AUTHORS: 2,
        ORGANIZATION: 3,
        SHORT_DESCRIPTION: 4,
        PUBLICATION_YEAR: 5,
        WEBLINK: 6,
        RESOURCE_TYPE_1: 7,
        RESOURCE_TYPE_2: 8,
        LENGTH: 9,
        AUDIENCE: 10,
        REFERENCES_WWC_STANDARDS: 11,
        SHORT_CYCLE: 12,
        LOW_COST: 13,
        EDUCATOR_DEVELOPMENT: 14,
        OTHER_EDUCATION_TOPICS: 15,
        RCT: 16,
        QED: 17,
        RDD: 18,
        SCD: 19,
        IDENTIFYING_COMPARISON_GROUPS: 20,
        DETERMINING_SAMPLE_SIZES: 21,
        RECRUITING_STUDY_PARTICIPANTS: 22,
        ADDRESSING_CHANGES_IN_YOUR_SAMPLE: 23,
        REDUCING_BIAS_IN_COMPARISON_GROUPS: 24,
        ACQUIRING_ADMINISTRATIVE_DATA: 25,
        SELECTING_APPROPRIATE_OUTCOME_MEASURES: 26,
        COLLECTING_NEW_DATA: 27,
        COMBINING_DATA_SYSTEMS: 28,
        UNDERSTANDING_DATA_ANALYTIC_MODELS: 29,
        ADDRESSING_ANALYSIS_CHALLENGES: 30,
        REPORTING_FINDINGS: 31,
        VISUALIZING_DATA: 32,
        STUDENT_ACHIEVEMENT: 33,
        STUDENT_BEHAVIOR: 34,
        TEACHER: 35,
        PRINCIPAL_SCHOOL: 36,
        DISTRICT: 37,
        ASSOCIATED_KEYWORDS: 38,
        LENGTH_FILTER_GROUP: 39,
        ANY_EXAMPLE_OUTCOME_MEASURES: 40,
        IS_BRIEF_OR_SUMMARY: 41,
        IS_GUIDE: 42,
        IS_TOOL: 43, 
        IS_METHODS_REPORTS: 44,
        IS_VIDEO: 45,
        IS_WEBINAR: 46,
        IS_SLIDE_PRESENTATION: 47,
        INITIAL_PLANNING: 48
    };

    var HeadersAndLabels = [
        "Resource ID",
        "Title",
        "Author(s)",
        "Hosting/Publishing Organization",
        "Short Description",
        "Year of Publication",
        "Weblink",
        "Type of Resource 1",
        "Type of Resource 2",
        "Length",
        "Audience",
        "References WWC Standards",
        "Short-Cycle Methods",
        "Low-Cost Approaches",
        "Educator Development Focus",
        "Other Education Topics",
        "Randomized Controlled Trials (RCT)",
        "Quasi-Experimental Design (QED)",
        "Regression Discontinuity Design (RDD)",
        "SCD",
        "Identify Comparison Groups",
        "Determine Sample Sizes",
        "Recruit Study Participants",
        "Address Changes in your Sample",
        "Reduce Bias in Comparison Groups",
        "Acquire Administrative Data",
        "Select Appropriate Outcome Measures",
        "Collect New Data",
        "Combine Data Systems",
        "Understand Data Analytic Models",
        "Address Analysis Challenges",
        "Report, Interpret, and Use Findings",
        "Visualize Data",
        "Student Achievement",
        "Student Behavior",
        "Teacher",
        "Principal/School",
        "District",
        "Associated Keywords",
        "Length Filter Group",
        "Any Examples of Outcome Measures",
        "Brief or Summary",
        "Guide",
        "Tool",
        "Methods Reports",
        "Video",
        "Webinar",
        "Slide Presentation",
        "Initial Planning"
    ];

    var filteredColumns = [];

    var resourceTable = $('#resourceList').DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-6'i><'col-sm-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'l><'col-sm-7'p>>",
        columnDefs: [
          {
              "targets": [0],
              "visible": false,
              "searchable": false
          },
          {
              "targets": [4, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48],
              "visible": false
          },
          {
              "targets": [6],
              "searchable": false
          }
        ]
    });

    /**
     * filterColumn() uses the DataTables custom search API to filter the
     * table based on the column and value passed in
     *
     * @param {Integer} i : the column index to search
     * @param {String} filterValue : the value to search for
     */
    function filterColumn(i, filterValue) {
        $('#resourceList').DataTable().column(i).search(filterValue).draw();
    }

    /*
     * row click handler
     */
    $('#resourceList tbody').on("click", "tr", function (event) {

        var cell = $(event.target).closest('td');
        
        if (cell.index() !== 4) {

            var resource = resourceTable.row(this).data();

            var audience = '';
            if (resource[DataSetIndexes.AUDIENCE] === 'P') {
                audience = 'Non-Technical Audience';
            } else if (resource[DataSetIndexes.AUDIENCE] === 'R') {
                audience = 'Researcher';
            }

            var resourceTypesString = "";
            if (resource[DataSetIndexes.RESOURCE_TYPE_1].trim().length > 0) {
                resourceTypesString += resource[DataSetIndexes.RESOURCE_TYPE_1].trim();
            }
            if (resource[DataSetIndexes.RESOURCE_TYPE_2].trim().length > 0) {
                if (resourceTypesString.length > 0) {
                    resourceTypesString += ", " + resource[DataSetIndexes.RESOURCE_TYPE_2].trim();
                } else {
                    resourceTypesString += resource[DataSetIndexes.RESOURCE_TYPE_2].trim();
                }
            }

            var basicInfoBody = "<p><b>Title:</b> " + resource[DataSetIndexes.TITLE] + "</p>" +
              "<p><b>Author(s):</b> " + resource[DataSetIndexes.AUTHORS] + "</p>" +
              "<p><b>Hosting/publishing organization:</b> " + resource[DataSetIndexes.ORGANIZATION] + "</p>" +
              "<p><b>Year of publication:</b> " + resource[DataSetIndexes.PUBLICATION_YEAR] + "</p>" +
              "<p><b>Short Description:</b><br/>" + resource[DataSetIndexes.SHORT_DESCRIPTION] + "</p>";

            var resourceCharacteristicsBody = "<p><b>Audience:</b></b> " + audience + "</p>" +
              "<p><b>Type of Resource:</b> " + resourceTypesString + "</p>" +
              "<p><b>Length:</b> " + resource[DataSetIndexes.LENGTH] + "</p>";
              
            var studyDesignList = [];
            if (resource[DataSetIndexes.INITIAL_PLANNING].toUpperCase() === TRUE) {
                studyDesignList.push("Initial Planning");
            }
            if (resource[DataSetIndexes.RCT].toUpperCase() === TRUE) {
                studyDesignList.push("Randomized Controlled Trials (RCT)");
            }
            if (resource[DataSetIndexes.QED].toUpperCase() === TRUE) {
                studyDesignList.push("Quasi-Experimental Design (QED)");
            }
            if (resource[DataSetIndexes.RDD].toUpperCase() === TRUE) {
                studyDesignList.push("Regression Discontinuity Design (RDD) ");
            }

            var sampleList = [];
            if (resource[DataSetIndexes.IDENTIFYING_COMPARISON_GROUPS].toUpperCase() === TRUE) {
                sampleList.push("Identify Comparison Groups");
            }
            if (resource[DataSetIndexes.DETERMINING_SAMPLE_SIZES].toUpperCase() === TRUE) {
                sampleList.push("Determine Sample Sizes");
            }
            if (resource[DataSetIndexes.RECRUITING_STUDY_PARTICIPANTS].toUpperCase() === TRUE) {
                sampleList.push("Recruit Study Participants");
            }
            if (resource[DataSetIndexes.ADDRESSING_CHANGES_IN_YOUR_SAMPLE].toUpperCase() === TRUE) {
                sampleList.push("Address Changes in your Sample");
            }
            if (resource[DataSetIndexes.REDUCING_BIAS_IN_COMPARISON_GROUPS].toUpperCase() === TRUE) {
                sampleList.push("Reduce Bias in Comparison Groups");
            }

            var dataCollectionList = [];
            if (resource[DataSetIndexes.SELECTING_APPROPRIATE_OUTCOME_MEASURES].toUpperCase() === TRUE) {
                dataCollectionList.push("Select Appropriate Outcome Measures");
            }
            if (resource[DataSetIndexes.ACQUIRING_ADMINISTRATIVE_DATA].toUpperCase() === TRUE) {
                dataCollectionList.push("Acquire Administrative Data");
            }
            if (resource[DataSetIndexes.COLLECTING_NEW_DATA].toUpperCase() === TRUE) {
                dataCollectionList.push("Collect New Data");
            }

            var dataAnalysisList = [];
            if (resource[DataSetIndexes.COMBINING_DATA_SYSTEMS].toUpperCase() === TRUE) {
                dataAnalysisList.push("Combine Data Systems");
            }
            if (resource[DataSetIndexes.UNDERSTANDING_DATA_ANALYTIC_MODELS].toUpperCase() === TRUE) {
                dataAnalysisList.push("Understand Data Analytic Models");
            }
            if (resource[DataSetIndexes.ADDRESSING_ANALYSIS_CHALLENGES].toUpperCase() === TRUE) {
                dataAnalysisList.push("Address Analysis Challenges");
            }

            var reportingDataList = [];
            if (resource[DataSetIndexes.REPORTING_FINDINGS].toUpperCase() === TRUE) {
                reportingDataList.push("Report, Interpret, and Use Findings");
            }
            if (resource[DataSetIndexes.VISUALIZING_DATA].toUpperCase() === TRUE) {
                reportingDataList.push("Visualize Data");
            }

            var researchMethodologyBody = "";
            
            if (studyDesignList.length > 0) {
                researchMethodologyBody += "<p><b>Plan and Design:</b> " + studyDesignList.join(", ");
            }
            if (sampleList.length > 0) {
                researchMethodologyBody += "<p><b>Identify and Follow Participants:</b> " + sampleList.join(", ");
            }
            if (dataCollectionList.length > 0) {
                researchMethodologyBody += "<p><b>Collect and Store Data:</b> " + dataCollectionList.join(", ");
            }
            if (dataAnalysisList.length > 0) {
                researchMethodologyBody += "<p><b>Analyze Data:</b> " + dataAnalysisList.join(", ");
            }
            if (reportingDataList.length > 0) {
                researchMethodologyBody += "<p><b>Report and Use Findings:</b> " + reportingDataList.join(", ");
            }

            var specialEvaluationTopicsList = [];
            if (resource[DataSetIndexes.LOW_COST].toUpperCase() === TRUE) {
                specialEvaluationTopicsList.push("Low-Cost Approaches");
            }
            if (resource[DataSetIndexes.SHORT_CYCLE].toUpperCase() === TRUE) {
                specialEvaluationTopicsList.push("Short-Cycle Methods");
            }
            if (resource[DataSetIndexes.EDUCATOR_DEVELOPMENT].toUpperCase() === TRUE) {
                specialEvaluationTopicsList.push("Educator Effectiveness Focus");
            }
            if (resource[DataSetIndexes.REFERENCES_WWC_STANDARDS].toUpperCase() === TRUE) {
                specialEvaluationTopicsList.push("References WWC Standards");
            }

            var educationOutcomeMeasuresList = [];
            if (resource[DataSetIndexes.STUDENT_ACHIEVEMENT].toUpperCase() === TRUE) {
                educationOutcomeMeasuresList.push("Student Achievement");
            }
            if (resource[DataSetIndexes.STUDENT_BEHAVIOR].toUpperCase() === TRUE) {
                educationOutcomeMeasuresList.push("Student Behavior");
            }
            if (resource[DataSetIndexes.TEACHER].toUpperCase() === TRUE) {
                educationOutcomeMeasuresList.push("Teacher");
            }
            if (resource[DataSetIndexes.PRINCIPAL_SCHOOL].toUpperCase() === TRUE) {
                educationOutcomeMeasuresList.push("Principal/School");
            }
            if (resource[DataSetIndexes.DISTRICT].toUpperCase() === TRUE) {
                educationOutcomeMeasuresList.push("District");
            }
            
            var resourceContentBody = '';
            if (specialEvaluationTopicsList.length > 0) {
                resourceContentBody += "<p><b>Special Evaluation Topics:</b> " + specialEvaluationTopicsList.join(", ");
            }
            if (educationOutcomeMeasuresList.length > 0) {
                resourceContentBody += "<p><b>Examples of Outcome Measures:</b> " + educationOutcomeMeasuresList.join(", ");
            }

            $('#basicInfoPanel').html(basicInfoBody);
            $('#evalLifecyclePanel').html(researchMethodologyBody);
            $('#resourceCharacteristicsPanel').html(resourceCharacteristicsBody);
            $('#resourceContentPanel').html(resourceContentBody);
            $("#detailModal").modal();
        }

    });

    /** filter handlers **/

    /**
     *  $('#clearAllBtn').click() clears all the filters and search results
     *      from the data table.uses the DataTables custom search API to filter the
     */
    $('#clearAllBtn').click(function () {
        $('input:checkbox').prop("checked", false);
        $('input:radio').prop("checked", false);
        $('#resourceList').DataTable().search('').columns().search('').draw();
        $('#searchString').html('');
        filteredColumns = [];
    });

    /* audience filters */
    $("input[name=audienceRadio]:radio").change(function () {
        
        if ($(this).val() === 'P') {
            if (filteredColumns.indexOf('Non-Technical Audience ') < 0) {
                filteredColumns.push('Non-Technical Audience ');
            }
            if (filteredColumns.indexOf('Researcher') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('Researcher'), 1);
            }
            filterColumn(DataSetIndexes.AUDIENCE, $(this).val());
        } else if ($(this).val() === 'R') {
            if (filteredColumns.indexOf('Researcher') < 0) {
                filteredColumns.push('Researcher');
            }
            if (filteredColumns.indexOf('Non-Technical Audience ') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('Non-Technical Audience '), 1);
            }
            filterColumn(DataSetIndexes.AUDIENCE, $(this).val());
        } else {
            if (filteredColumns.indexOf('Non-Technical Audience ') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('Non-Technical Audience '), 1);
            }
            if (filteredColumns.indexOf('Researcher') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('Researcher'), 1);
            }
            filterColumn(DataSetIndexes.AUDIENCE, "");
        }
        $('#searchString').html(filteredColumns.join(" <i><strong>AND</strong></i> "));
    });

    /* length filters */
    $("input[name=lengthRadio]:radio").change(function () {

        if ($(this).val() === '1') {
            if (filteredColumns.indexOf('5 Pages or Less/5 min video or less') < 0) {
                filteredColumns.push('5 Pages or Less/5 min video or less');
            }
            if (filteredColumns.indexOf('6-20 pages/6-20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('6-20 pages/6-20 min video'), 1);
            }
            if (filteredColumns.indexOf('More than 20 Pages/ More than 20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('More than 20 Pages/ More than 20 min video'), 1);
            }
            filterColumn(DataSetIndexes.LENGTH_FILTER_GROUP, $(this).val());
        } else if ($(this).val() === '2') {
            if (filteredColumns.indexOf('6-20 pages/6-20 min video') < 0) {
                filteredColumns.push('6-20 pages/6-20 min video');
            }
            if (filteredColumns.indexOf('5 Pages or Less/5 min video or less') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('5 Pages or Less/5 min video or less'), 1);
            }
            if (filteredColumns.indexOf('More than 20 Pages/ More than 20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('More than 20 Pages/ More than 20 min video'), 1);
            }
            filterColumn(DataSetIndexes.LENGTH_FILTER_GROUP, $(this).val());
        } else if ($(this).val() === '3') {
            if (filteredColumns.indexOf('More than 20 Pages/ More than 20 min video') < 0) {
                filteredColumns.push('More than 20 Pages/ More than 20 min video');
            }
            if (filteredColumns.indexOf('5 Pages or Less/5 min video or less') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('5 Pages or Less/5 min video or less'), 1);
            }
            if (filteredColumns.indexOf('6-20 pages/6-20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('6-20 pages/6-20 min video'), 1);
            }
            filterColumn(DataSetIndexes.LENGTH_FILTER_GROUP, $(this).val());
        } else {
            if (filteredColumns.indexOf('5 Pages or Less/5 min video or less') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('5 Pages or Less/5 min video or less'), 1);
            }
            if (filteredColumns.indexOf('6-20 pages/6-20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('6-20 pages/6-20 min video'), 1);
            }
            if (filteredColumns.indexOf('More than 20 Pages/ More than 20 min video') >= 0) {
                filteredColumns.splice(filteredColumns.indexOf('More than 20 Pages/ More than 20 min video'), 1);
            }
            filterColumn(DataSetIndexes.LENGTH_FILTER_GROUP, "");
        }
        $('#searchString').html(filteredColumns.join(" <i><strong>AND</strong></i> "));
    });

    $("input.trueFalseCB:checkbox").click(function () {
        if ($(this).prop("checked") === true) {
            filterColumn($(this).data("filter-id"), 'True');
            filteredColumns.push(HeadersAndLabels[$(this).data("filter-id")]);
        }
        else if ($(this).prop("checked") === false) {
            filterColumn($(this).data("filter-id"), '');
            filteredColumns.splice(filteredColumns.indexOf(HeadersAndLabels[$(this).data("filter-id")]), 1);
        }
        $('#searchString').html(filteredColumns.join(" <i><strong>AND</strong></i> "));
    });
    
    /** Remove empty paragraph generated by WordPress **/
    $('#resourceFilters p').filter(function () { return $.trim(this.innerHTML) == "" }).remove();
});