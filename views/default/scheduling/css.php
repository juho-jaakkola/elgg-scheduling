//<style>
    .elgg-form-scheduling-days .elgg-icon {
        margin-left: 10px;
    }

    #elgg-scheduling-answer-container {
        width: 710px;
        overflow: auto;
        margin: 0 0 30px 0;
    }

    #elgg-table-scheduling {
        margin: 10px 0;
    }

    #elgg-table-scheduling-answer {
        border: 0;
    }

    #elgg-table-scheduling-answer td,
    #elgg-table-scheduling-answer th {
        text-align: center;
    }

    #elgg-table-scheduling-answer .answerYes {
        background: lightgreen;
    }

    #elgg-table-scheduling-answer .answerMaybe {
        background: #FFFFAA;
    }

    #elgg-table-scheduling-answer .answerNo {
        background: #FFC8F2;
    }

    #elgg-table-scheduling-answer .answerUndefined {
        background: #CCC;
    }

    #elgg-table-scheduling-answer td.empty,
    #elgg-table-scheduling-answer th.empty {
        border: 0;
        background: white;
    }

    .scheduling-state-error {
        /* Important is needed to override the default :focus styles */
        border: 1px solid red !important;
    }

    /* FORM answer */
    .hiddenRadio{ /* HIDE RADIO */
        visibility: hidden; /* Makes input not-clickable */
        position: absolute; /* Remove input from document flow */
    }

    .hiddenRadio + a{ 
        cursor:pointer;
    }

    .hiddenRadio:checked + a{ 
        text-decoration: underline;
    }

    .td-scheduling-date{
        width: 100px;
    }

    #scheduling-datepicker{
        width: 325px;
        margin-left: 30px;
        margin-top: 10px;

        float:left;
    }

    .elgg-table-alt td:first-child{
        width: 70px;
    }

    #date-selected{
        width:300px;
        height:300px;
        max-height: 600px;

        margin-top: 10px;
        margin-left: 50px;

        float:left;
        overflow: auto;

        font-size:20px;
        line-height: 1.5em;      
    }

    #scheduling-datepicker{
        font-size:25px;
    }

    .elgg-foot{
        clear: both;
    }

    .listElm{
        margin:10px;
        padding: 3px;
        display: inline-block;

        border: 1px grey groove;
        border-radius: 10px;
    }    

	.fixed{
		position:sticky; 
		/*width:70px; */
		/*height:70px;*/
		left:0;
		top:auto;
		/*padding-top: 50px;*/
		border-right: 0px none black; 
		border-top-width:3px; /*only relevant for first row*/
		margin-top:-3px; /*compensate for top border*/
	
	}
