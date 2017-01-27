
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

#elgg-table-scheduling-answer .yes {
	background: lightgreen;
}

#elgg-table-scheduling-answer .maybe {
	background: #FFFFAA;
}

#elgg-table-scheduling-answer .no {
	background: #FFC8F2;
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
    margin:60px;
    width:230px;
    display:inline-block;
    backgroung-color: red;
}

.scheduling-actions{
    width: 40px;
}

#date-selected{
    width:300px;
    padding: 20px;
    marging: 50px;
    height:200px;
    background-color: yellow;
}
